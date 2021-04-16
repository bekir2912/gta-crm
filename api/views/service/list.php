<?php
/* @var $this yii\web\View */


use common\models\Language;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\widgets\WSocials;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
$this->registerCss('
    #map {
        width: 100%;
        height: 100%;
    }
');

$this->title = $category->translate->name;
$breads = [];

$temp_parent = $category;
while($temp_parent){
    $breads[] = $temp_parent;
    if(!$temp_parent->parent) break;
    $temp_parent = $temp_parent->parent;
}
$breads = array_reverse($breads);


$this->registerMetaTag([
    'name' => 'description',
    'content' => Html::encode(strip_tags($category->translate->description)),
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Html::encode(strip_tags($category->translate->description)),
]);

$sort = [
    'price' => [
        'label' => 'price',
        'get' => ['s' => 'p', 'sd' => (Yii::$app->request->get('d') == 'a' ? 'd' : 'a')],
    ],
    'view' => [
        'label' => 'view',
        'get' => ['s' => 'v', 'sd' => (Yii::$app->request->get('d') == 'a' ? 'd' : 'a')],
    ],
];

if (Yii::$app->request->get('s') == 'p' ||
    Yii::$app->request->get('s') == 'v' ||
    Yii::$app->request->get('s') == 'd'
) {
    if (Yii::$app->request->get('sd') == 'a') {
        $fa_sort_icon[Yii::$app->request->get('s')] = FA::i('sort-amount-asc');
    } elseif (Yii::$app->request->get('sd') == 'd') {
        $fa_sort_icon[Yii::$app->request->get('s')] = FA::i('sort-amount-desc');
    } else $fa_sort_icon[Yii::$app->request->get('s')] = FA::i('sort-amount-desc');

} else $fa_sort_icon['v'] = FA::i('sort-amount-desc');

if(Yii::$app->user->id){
    $userFav = \common\models\UserFavorite::find()->where(['user_id' => Yii::$app->user->id])->orderBy('`created_at` DESC')->all();
    $product_ids = array();
    if(!empty($userFav)) {
        for ($i = 0; $i < count($userFav); $i++) {
            $product_ids[] = $userFav[$i]->product_id;
        }
    }
}
else {
    $product_ids = !empty(Yii::$app->session->get('product_ids')) ? Yii::$app->session->get('product_ids') : array();
}

?>

<div class="service-left">
    <div class="service">
        <div class="service-width">


            <?php if (count($breads) > 1) { ?>
                <div class="bread-crumbs">
                    <ul class="bread-crumbs__list">
                        <?php for($i = 0; $i < count($breads); $i++) { ?>
                            <li class="bread-crumbs__item">
                                <?php if ($i + 1 != count($breads)) { ?>
                                <a href="<?=Url::to(['service/list', 'id' => $breads[$i]->url])?>" class="bread-crumbs__link">
                                    <?php } ?>
                                    <?=$breads[$i]->translate->name?>
                                    <?php if ($i + 1 != count($breads)) { ?>
                                </a>
                            <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <?php if ($category->activeCategories) { ?>

                <h3 class="service-list__heading service-list__category">
                    <?=Yii::t('frontend', 'Choose Category')?>
                </h3>
                <div class="service__link-block clearfix">
                    <?php for ($s = 0; $s < count($category->activeCategories); $s++) { ?>
                        <a class="service-block__link" href="<?=Url::to(['service/list', 'id' => $category->activeCategories[$s]->url])?>">
                            <img src="<?=$category->activeCategories[$s]->icon?>" alt="" style="display: inline-block;vertical-align: top"/>
                            <span class="service-block__text">
                            <?=$category->activeCategories[$s]->translate->name?>
                        </span>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>


            <h3 class="service-list__heading service-list__category">
                <?=$category->translate->name?>
            </h3>
            <div class="service-list clearfix">


                <?php if (!empty($filtered_shops)) { ?>
                        <?php for ($i = 0; $i < count($filtered_shops); $i++) { ?>

                        <div class="service-list__item">
                            <a href="<?=Url::to(['service/index', 'id' => $filtered_shops[$i]->url, 'cat' => $category->url])?>">
                                <img src="<?=$filtered_shops[$i]->logo?>" class="service-list__image" >
                            </a>
                            <div class="service-list__block">
                                <a href="<?=Url::to(['service/index', 'id' => $filtered_shops[$i]->url, 'cat' => $category->url])?>" style="color: inherit;">
                                    <h4 class="service-list__item-heading" style="float: left;">
                                        <?=$filtered_shops[$i]->name?>
                                    </h4>
                                    <?php if($filtered_shops[$i]->rating > 0) { ?>
                                        <p class="comment-block" style="float: right;">
                                                <?php for($r = 1; $r < 6; $r++) { ?>
                                                    <?php
                                                    $ost = $r - $filtered_shops[$i]->rating;
                                                    ?>
                                                    <?php if($ost < 1 && $ost > 0) { ?>
                                                        <span class="fa fa-star-half-full comment-star"></span>
                                                    <?php } else { ?>
                                                        <span class="fa fa-star<?=($r <= $filtered_shops[$i]->rating)? '': '-o'?> comment-star"></span>
                                                    <?php } ?>
                                                <?php } ?>
                                            <span class="comment_count"><?=$filtered_shops[$i]->getReviewsCount()?> <i class="fa fa-comment"></i></span>
                                            </p>
                                    <?php } ?>
                                    <span class="clearfix"></span>
                                </a>

                                <?php if($filtered_shops[$i]->info->address != '') { ?>
                                    <p class="service-list__text">
                                        <?=$filtered_shops[$i]->info->address?>
                                    </p>
                                <?php } ?>

                                <?php if($filtered_shops[$i]->info->description != '') { ?>
                                    <p class="service-list__work-time" data-toggle="modal" data-target="#description<?=$filtered_shops[$i]->id?>" style="margin: 0 15px 8px 0;display: inline-block;border-bottom: 1px dashed #6b6b6b;">
                                        <?= Yii::t('frontend', 'Description') ?>
                                    </p>
                                    <!-- Modal -->
                                    <div class="modal fade" id="description<?=$filtered_shops[$i]->id?>" tabindex="-1" role="dialog" aria-labelledby="descriptionLabel">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body ">
                                                    <?= nl2br($filtered_shops[$i]->info->description) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($filtered_shops[$i]->info->scheduleForm != '') { ?>
                                    <p class="service-list__work-time" data-toggle="modal" data-target="#schedule<?=$filtered_shops[$i]->id?>" style="margin: 0 0 8px;display: inline-block;border-bottom: 1px dashed #6b6b6b;">
                                        <?= Yii::t('frontend', 'Schedule') ?>
                                    </p>
                                    <!-- Modal -->
                                    <div class="modal fade" id="schedule<?=$filtered_shops[$i]->id?>" tabindex="-1" role="dialog" aria-labelledby="scheduleLabel">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body ">
                                                    <?= nl2br($filtered_shops[$i]->info->scheduleForm) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                <?php } ?>



                                <div class="clearfix"></div>
                                <?php if (($filtered_shops[$i]->info->phone != '')) { ?>
                                    <button class="service-list__tel show_shop_phone" style="float: none;" data-shop="<?=$filtered_shops[$i]->id?>">
                                        <i class="flaticon-auricular-phone-symbol-in-a-circle"></i>
                                        <?=Yii::t('frontend', 'Show shop number')?>
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                <div class="service-list__item">
                    <div class="pagination-block">
                        <?php echo LinkPager::widget([
                            'pagination' => $pagination,
                        ]); ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
    <div class="service-footer">
        <div class="service-footer-width">
            <div class="service-footer__block-soc">
                <?= WSocials::widget(); ?>
            </div>
            <div class="service-footer-buttons">
                <?=Yii::t('frontend', 'App Store')?>
                <?=Yii::t('frontend', 'Google Play')?>
            </div>
            <p class="service-footer__copyright">
                © 2017-<?=date('Y')?> <?=Yii::t('common', 'copy')?>
            </p>

            <div class="service-footer__developer">
                <?=Yii::t('common', 'powered')?>
            </div>
        </div>
    </div>
</div>
<div class="map-block ">
    <div class="back-to-service">
        <button class="back-to-service__button">
            <i class="flaticon-back"></i>
        </button>
        <h3 class="service-name">
            <?=$category->translate->name?>
        </h3>
    </div>
    <div class="map-container">
        <div id="map"></div>
        <script>
            function initMap() {
                <?php if($city && $city->lat && $city->lng) { ?>
                var myLatLng = {lat: <?=$city->lat?>, lng: <?=$city->lng?>};
                var zoom = 11;
                <?php } else { ?>
                var myLatLng = {lat: 41.4450174, lng: 64.8666701};
                var zoom = 6;
                <?php } ?>

                var map = new google.maps.Map(document.getElementById('map'), {
                    center: myLatLng,
                    zoom: zoom
                });

                <?php if (!empty($filtered_shops)) { ?>
                    <?php for ($i = 0; $i < count($filtered_shops); $i++) { ?>
                    <?php if ($filtered_shops[$i]->info->lat && $filtered_shops[$i]->info->lng) { ?>
                        var infowindow<?=$i?> = new google.maps.InfoWindow({
                            content: '<?=$filtered_shops[$i]->name?>'
                        });

                        var marker<?=$i?> = new google.maps.Marker({
                            map: map,
                            position: {lat: <?=$filtered_shops[$i]->info->lat?>, lng: <?=$filtered_shops[$i]->info->lng?>},
                            // icon: '/site/map-icon',
                            title: '<?=$filtered_shops[$i]->name?>'
                        });

                        marker<?=$i?>.addListener('click', function () {
                            infowindow<?=$i?>.open(map, marker<?=$i?>);
                        });
                    <?php } ?>
                    <?php } ?>
                <?php } ?>
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_x1j3WR5rH6hMDlm2_wfcVK7EI-30fx8&callback=initMap&language=<?= Language::getCurrent()->url ?>"
                async defer></script>
    </div>
</div>
