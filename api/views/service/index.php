<?php
/* @var $this yii\web\View */


use common\models\Language;
use common\models\ShopReview;
use rmrevin\yii\fontawesome\FA;
use frontend\widgets\WSocials;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$currency = Yii::$app->session->get('currency', 'uzs');
$this->registerCss('
    #map {
        width: 100%;
        height: 100%;
    }
');
$this->title = $shop->name;


$this->registerMetaTag([
    'name' => 'description',
    'content' => Html::encode(strip_tags($shop->info->description)),
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Html::encode(strip_tags($shop->info->description)),
]);

$temp_parent = $category;

$breads = [$shop];
while($temp_parent){
    $breads[] = $temp_parent;
    if(!$temp_parent->parent) break;
    $temp_parent = $temp_parent->parent;
}
$breads = array_reverse($breads);


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

if (Yii::$app->user->id) {
    $userFav = \common\models\UserFavorite::find()->where(['user_id' => Yii::$app->user->id])->orderBy('`created_at` DESC')->all();
    $product_ids = array();
    if (!empty($userFav)) {
        for ($i = 0; $i < count($userFav); $i++) {
            $product_ids[] = $userFav[$i]->product_id;
        }
    }
} else {
    $product_ids = !empty(Yii::$app->session->get('product_ids')) ? Yii::$app->session->get('product_ids') : array();
}

use yii\widgets\Pjax;

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
                                        <?=(isset($breads[$i]->translate))? $breads[$i]->translate->name: $breads[$i]->name?>
                                        <?php if ($i + 1 != count($breads)) { ?>
                                    </a>
                                <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <div class="service-list clearfix">
                    <div class="service-list__item">
                            <img src="<?=$shop->logo?>" class="service-list__image">
                        <div class="service-list__block">
                                <h4 class="service-list__item-heading">
                                    <?=$shop->name?>
                                </h4>

                            <?php if($shop->info->address != '') { ?>
                                <p class="service-list__text">
                                    <?=$shop->info->address?>
                                </p>
                            <?php } ?>
                            <?php if ($shop->info->scheduleForm != '') { ?>
                                <p class="service-list__work-time" data-toggle="modal" data-target="#schedule<?=$shop->id?>" style="margin: 0 0 8px;display: inline-block;border-bottom: 1px dashed #6b6b6b;">
                                    <?= Yii::t('frontend', 'Schedule') ?>
                                </p>
                                <!-- Modal -->
                                <div class="modal fade" id="schedule<?=$shop->id?>" tabindex="-1" role="dialog" aria-labelledby="scheduleLabel">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body ">
                                                <?= nl2br($shop->info->scheduleForm) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                            <?php } ?>
                            <div class="clearfix"></div>
                            <?php if (($shop->info->phone != '')) { ?>
                                <button class="service-list__tel show_shop_phone" style="float: none;" data-shop="<?=$shop->id?>">
                                    <i class="flaticon-auricular-phone-symbol-in-a-circle"></i>
                                    <?=Yii::t('frontend', 'Show shop number')?>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                    <section class="result-of-search clearfix" id="search-result">
                        <?php if($shop->rating > 0) { ?>
                            <p class="comment-block show_reviews pointer">
                                <?php for($r = 1; $r < 6; $r++) { ?>
                                    <?php
                                        $ost = $r - $shop->rating;
                                    ?>
                                    <?php if($ost < 1 && $ost > 0) { ?>
                                        <span class="fa fa-star-half-full comment-star"></span>
                                    <?php } else { ?>
                                        <span class="fa fa-star<?=($r <= $shop->rating)? '': '-o'?> comment-star"></span>
                                    <?php } ?>
                                <?php } ?>
                                <span class="comment_count"><?=$shop->getReviewsCount()?> <i class="fa fa-comment"></i></span>
                            </p>
                        <?php } else { ?>
                            <p class="comment-block">
                                <a  class="show_reviews pointer"><?=Yii::t('frontend', 'No reviews')?></a>
                            </p>
                        <?php } ?>
                        <p class="separator"></p>
                        <?php if($shop->info->description != '') { ?>
                            <p class="service-description">
                                <?=$shop->info->description?>
                            </p>
                        <?php } ?>
                        <h3 class="result-of-search__heading">
                            <?=Yii::t('frontend', 'Services')?>
                        </h3>

                        <?php if (!empty($products)) { ?>
                            <div class="product-list clearfix">
                                <?php for ($i = 0; $i < count($products); $i++) { ?>
                                    <div class="product-list__item">
                                        <table class="table">
                                            <tr <?php if ($products[$i]->translate->description != '') { ?> data-toggle="collapse" href="#collapse<?= $products[$i]->id ?>" aria-expanded="false" aria-controls="collapse<?= $products[$i]->id ?>"<?php } ?>>
                                                <td style="width: 32px;vertical-align: middle;">
                                                    <img src="<?= $products[$i]->mainImage->image ?>" class="product-list__img" style="width: 32px;height: 32px;">
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <?= $products[$i]->translate->name ?>
                                                </td>
                                                <td class="text-right" style="vertical-align: middle;">
                                                    <?php if ($products[$i]->price_type == 0) {
                                                        $wholesales = json_decode($products[$i]->wholesale);
                                                        ?>
                                                        <?php if ($products[$i]->price == 0) { ?>
                                                            <?= Yii::t('frontend', 'Specify prices from the seller') ?>
                                                        <?php } else { ?>
                                                            <?= $products[$i]->showPrice ?>
                                                        <?php } ?>
                                                    <?php } elseif ($products[$i]->price_type == 1) {
                                                        $wholesales = json_decode($products[$i]->wholesale);
                                                        ?>
                                                        <?php if (!empty($wholesales)) { ?>
                                                            <?php foreach ($wholesales as $ws_count => $sum) {

                                                                $ws_price = (preg_match('/\./i', $sum)) ? number_format($sum, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']) : number_format($sum, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
                                                                $ws_price = preg_replace('/,00$/i', '', $ws_price);
                                                                ?>
                                                                <?= $ws_price ?> <?= Yii::t('frontend', $currency) ?>
                                                                <?php break; } ?>
                                                        <?php } else { ?>
                                                            <?= Yii::t('frontend', 'Specify prices from the seller') ?>
                                                        <?php } ?>
                                                    <?php } elseif ($products[$i]->price_type == 2) {
                                                        $wholesales = json_decode($products[$i]->wholesale);
                                                        ?>
                                                        <?php if ($products[$i]->price == 0) { ?>
                                                            <?php if (!empty($wholesales)) { ?>
                                                                <?php foreach ($wholesales as $ws_count => $sum) {
                                                                    $ws_price = (preg_match('/\./i', $sum)) ? number_format($sum, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']) : number_format($sum, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
                                                                    $ws_price = preg_replace('/,00$/i', '', $ws_price);
                                                                    ?>
                                                                    <?= $ws_price ?> <?= Yii::t('frontend', $currency) ?>
                                                                    <?php break; } ?>
                                                            <?php } else { ?>
                                                                <?= Yii::t('frontend', 'Specify prices from the seller') ?>
                                                            <?php } ?>

                                                        <?php } else { ?>
                                                            <?= $products[$i]->showPrice ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if ($products[$i]->translate->description != '') { ?> <i class="fa fa-chevron-down text-muted" style="font-size: 11px;"></i> <?php } ?>
                                                </td>
                                            </tr>
                                            <?php if ($products[$i]->translate->description != '') { ?>
                                                <tr class="collapse" id="collapse<?= $products[$i]->id ?>">
                                                    <td colspan="3" style="border: none!important;font-size: 13px;color: #6b6b6b;">
                                                        <?=nl2br($products[$i]->translate->description) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <p class="separator"></p>
                        <p class="service-description" style="color: #8d8d8d;">
                            <?=Yii::t('frontend', 'Notice')?>
                        </p>
                        <p class="separator"></p>
                        <p class="separator"></p>
                        <div class="comments-block" id="comments-block">
                            <div class="add_comment">
                                <?php if(Yii::$app->user->isGuest) { ?>
                                    <p class="text-center ">
                                        <a href="<?= Url::to(['site/login']) ?>" >
                                            <?=Yii::t('frontend', 'Auth to review')?>
                                        </a>
                                    </p>
                                <?php } else {
                                    $review = ShopReview::find()->where(['user_id' => Yii::$app->user->id, 'shop_id' => $shop->id])->one();
                                    ?>
                                    <?php if($review) { ?>
                                        <div class="my-review-item" id="my-review-item">
                                            <div class="my-review-item-header">
                                                <div class="pull-left comment-block">
                                                    <?php for($r = 1; $r < 6; $r++) { ?>
                                                        <span class="fa fa-star<?=($r <= $review->rating)? '': '-o'?> comment-star"></span>
                                                    <?php } ?>
                                                    <strong style="margin-left: 15px;"><?=Yii::t('frontend', 'Your Review')?></strong>
                                                </div>
                                                <div class="pull-right text-muted">
                                                    <?=date('d.m.Y', $review->created_at)?>
                                                    <?=($review->status != 1)? '<span class="badge">'.Yii::t('frontend', 'Blocked').'</span>': ''?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="my-comment-item">
                                                <?=nl2br($review->comment)?>
                                            </div>
                                            <div class="">
                                                <button class="btn btn-primary" id="edit_comment_button">
                                                    <?=Yii::t('frontend', 'Edit')?>
                                                </button>
                                                <a class="btn btn-danger" href="<?=Url::to(['review/delete', 'id' => $review->id, 'shop_id' => $shop->id])?>" data-pjax="0" onclick="if(!confirm('<?=Yii::t('frontend', 'Confirm deleting');?>')) return false;">
                                                    <?=Yii::t('frontend', 'Delete')?>
                                                </a>
                                            </div>
                                        </div>

                                        <div id="edit_review_form" style="display: none;">
                                            <?php $form = ActiveForm::begin(['method' => 'post', 'action' => Url::to(['review/update'])]); ?>
                                            <label for="comment" style="text-transform: unset"><?=Yii::t('frontend', 'Rate service')?></label>
                                            <input type="hidden" name="shop_id" value="<?=$shop->id?>">
                                            <div class="set-stars " >
                                                <div class="rating">
                                                    <label>
                                                        <input type="radio" name="rating" value="1" <?=($review->rating == 1)? 'checked': ''?> required/>
                                                        <span class="icon">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="rating" value="2" <?=($review->rating == 2)? 'checked': ''?> required/>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="rating" value="3" <?=($review->rating == 3)? 'checked': ''?> required/>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="rating" value="4" <?=($review->rating == 4)? 'checked': ''?> required/>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="rating" value="5" <?=($review->rating == 5)? 'checked': ''?> required/>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="write-comment form-group">
                                                <textarea name="comment" class="form-control" id="comment" rows="5" placeholder="<?=Yii::t('frontend', 'comment_area_placeholder')?>"><?=$review->comment?></textarea>
                                            </div>
                                            <p>
                                                <a class=" pointer btn btn-danger" id="cancel_edit_comment_button"><?=Yii::t('frontend', 'Cancel')?></a>
                                                <button class="btn btn-success"><?=Yii::t('frontend', 'Add Review')?></button>
                                            </p>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                    <?php } else { ?>
                                        <?php $form = ActiveForm::begin(['method' => 'post', 'action' => Url::to(['review/add'])]); ?>
                                        <label for="comment" style="text-transform: unset"><?=Yii::t('frontend', 'Rate service')?></label>
                                        <input type="hidden" name="shop_id" value="<?=$shop->id?>">
                                        <div class="set-stars " >
                                            <div class="rating">
                                                <label>
                                                    <input type="radio" name="rating" value="1" checked required/>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="2" required/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="3" required/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="4" required/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="5" required/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="write-comment form-group">
                                            <textarea name="comment" class="form-control" id="comment" rows="5" placeholder="<?=Yii::t('frontend', 'comment_area_placeholder')?>"></textarea>
                                        </div>
                                        <p>
                                            <button class="btn btn-success"><?=Yii::t('frontend', 'Add Review')?></button>
                                        </p>
                                        <?php ActiveForm::end(); ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <?php if($shop->rating > 0) { ?>
                                <div class="reviews-list">
                                    <?php for ($ir = 0; $ir < count($shop->reviews); $ir++) {
                                        if($shop->reviews[$ir]->status != 1) continue;
                                        if($shop->reviews[$ir]->user_id == Yii::$app->user->id) continue;
                                        ?>
                                        <div class="review-item">
                                            <div class="my-review-item-header">
                                                <div class="pull-left comment-block">
                                                    <?php for($r = 1; $r < 6; $r++) { ?>
                                                        <span class="fa fa-star<?=($r <= $shop->reviews[$ir]->rating)? '': '-o'?> comment-star"></span>
                                                    <?php } ?>
                                                    <strong style="margin-left: 15px;"><?=$shop->reviews[$ir]->user->name?></strong>
                                                </div>
                                                <div class="pull-right text-muted">
                                                    <?=date('d.m.Y', $shop->reviews[$ir]->created_at)?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="my-comment-item">
                                                <?=nl2br($shop->reviews[$ir]->comment)?>
                                            </div>
                                        </div>
                                        <p class="separator"></p>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <p class="text-center text-muted" style="margin-bottom: 20px;">
                                    <?=Yii::t('frontend', 'No reviews')?>
                                </p>
                            <?php } ?>
                        </div>
                    </section>
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
                <?=$shop->name?>
            </h3>
        </div>
        <div class="map-container">
            <div id="map"></div>
            <script>
                function initMap() {
                    var myLatLng = {lat: <?=$shop->info->lat?>, lng: <?=$shop->info->lng?>};
                    var zoom = 13;

                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: myLatLng,
                        zoom: zoom
                    });

                    <?php if ($shop->info->lat && $shop->info->lng) { ?>
                    var infowindow = new google.maps.InfoWindow({
                        content: '<?=$shop->name?>'
                    });

                    var marker = new google.maps.Marker({
                        map: map,
                        position: {lat: <?=$shop->info->lat?>, lng: <?=$shop->info->lng?>},
                        // icon: '/site/map-icon',
                        title: '<?=$shop->name?>'
                    });

                    marker.addListener('click', function () {
                        infowindow.open(map, marker);
                    });
                    <?php } ?>
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_x1j3WR5rH6hMDlm2_wfcVK7EI-30fx8&callback=initMap&language=<?= Language::getCurrent()->url ?>"
                    async defer></script>
        </div>
    </div>

<?php
    $this->registerJs('
    $(".show_reviews").click(function() {
        $(".service-width").animate({
            scrollTop: $("#comments-block").offset().top
        }, 1000);
    });
    $("#edit_comment_button").click(function() {
        $("#my-review-item").hide();
        $("#edit_review_form").show();
    });
    $("#cancel_edit_comment_button").click(function() {
        $("#edit_review_form").hide();
        $("#my-review-item").show();
    });
    ');
?>