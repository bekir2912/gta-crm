<?php
/* @var $this yii\web\View */


use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use common\models\Language;

$this->title = $shop->name;

$this->registerCss('
    #map {
        width: 100%;
        height: 200px;
    }
');

$currency = Yii::$app->session->get('currency', 'uzs');
$this->registerMetaTag([
    'name' => 'description',
    'content' => Html::encode(strip_tags($shop->info->description)),
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Html::encode(strip_tags($shop->info->description)),
]);

$breads = [$shop];
$temp_parent = $category;
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

} else $fa_sort_icon['d'] = FA::i('sort-amount-desc');

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

$banners = \common\models\Banner::find()->where(['status' => 1, 'type' => 1])->andWhere(['>', 'expires_in', time()])->orderBy('order')->limit(5)->all();
use yii\widgets\Pjax;

?>

<?php if (count($breads) > 1) { ?>
    <div class="bread-crumbs">
        <ul class="bread-crumbs__list">
            <?php for($i = 0; $i < count($breads); $i++) { ?>
                <li class="bread-crumbs__item">
                    <?php if ($i + 1 != count($breads)) { ?>
                    <a href="<?=Url::to(['shop/list', 'id' => $breads[$i]->url])?>" class="bread-crumbs__link">
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
<?php if ($category->activeCategories) { ?>
    <div class="SubcategoriesList Subcategories">
        <?php for ($s = 0; $s < count($category->activeCategories); $s++) { ?>
            <div class="SubcategoriesList-item">
                <a class="navigation__dropdown-link" href="<?=Url::to(['shop/list', 'id' => $category->activeCategories[$s]->url])?>"><?=$category->activeCategories[$s]->translate->name?></a>
            </div>
        <?php } ?>
    </div>
<?php } ?>

    <section class="diller-cars">
        <div class="diller-cars__item">
            <div class="diller-cars__img-block">
                <img src="<?=$shop->logo?>" class="diller-cars__img">
            </div>
            <div class="diller-cars__info-block">
                <h3 class="diller-cars__heading">
                    <?=$shop->name?>
                </h3>

                <?php if (($shop->info->phone != '')) { ?>
                    <button class="diller-cars__phone-number show_shop_phone" style="border: 0;" data-shop="<?=$shop->id?>">
                        <i class="flaticon-auricular-phone-symbol-in-a-circle"></i>
                        <?=Yii::t('frontend', 'Show shop number')?>
                    </button>
                <?php } ?>
                <p class="diller-cars__info">
                    <?=Yii::t('frontend', 'Verified dealer')?>
                </p><br>
                <p class="diller-cars__auto">
                    <?=$category->translate->name?>:
                    <span>
                        <?=isset($shops_products[$shop->id])? $shops_products[$shop->id]: 0 ?> <?=Yii::t('frontend', 'unit')?>
                    </span>
                </p>
                <?php if($shop->info->address != '') { ?>
                    <p class="diller-cars__adress">
                        <?=Yii::t('frontend', 'Address')?>:
                        <span>
                                        <?=$shop->info->address?>
                                    </span>
                    </p>
                <?php } ?>
            </div>
            <!--            <div class="diller-cars__slider">-->
            <!--                <ul class="diller-cars__image-list">-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="diller-cars__image-item">-->
            <!--                        <a data-fancybox="gallery" href="img/img-1.jpg">-->
            <!--                            <img src="img/img-2.jpg" class="slide__image">-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </div>-->
            <div class="clearfix"></div>

            <?php if ($shop->info->lat && $shop->info->lng && $shop->info->description != '') { ?>
                <p class="separator"></p>
                <div class="row">
                    <div class="col-md-6">
                        <p class="service-description">
                            <?=$shop->info->description?>
                        </p>
                    </div>
                    <div class="col-md-6">
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
                <p class="separator"></p>
            <?php } else if($shop->info->description != '') { ?>
                <p class="separator"></p>
                <div class="row">
                    <div class="col-md-12">
                        <p class="service-description">
                            <?=$shop->info->description?>
                        </p>
                    </div>
                </div>
                <p class="separator"></p>
            <?php } else if($shop->info->lat && $shop->info->lng) { ?>
                <p class="separator"></p>
                <div class="row">
                    <div class="col-md-12">
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
                <p class="separator"></p>
            <?php } ?>
        </div>
    </section>
<?php Pjax::begin() ?>

<?php require_once('index_right.php') ?>

    <section class="result-of-search clearfix" id="search-result">
        <h3 class="result-of-search__heading">
            <?=Yii::t('frontend', 'Found variants')?>:
            <span class="result-of-search--bold">
                                <?=$pagination->totalCount?>
                            </span>
        </h3>

        <?php if (!empty($products)) { ?>
            <div class="result-of-search__filter-search" >
                <ul class="filter-search__list">
                    <li class="filter-search__item">
                        <div class="filter-search__dropdown">
                            <a class="filter-search__link sort-link" href="<?= Url::current(['s' => 'v', 'sd' => (Yii::$app->request->get('s') == '') ? 'a' : ((Yii::$app->request->get('s') == 'v' && Yii::$app->request->get('sd') == 'd') ? 'a' : 'd')]) ?>">
                                <?= Yii::t('frontend', 'By popularity') ?>
                                <?= (isset($fa_sort_icon['v']) ? $fa_sort_icon['v'] : '') ?>
                            </a>
                        </div>
                    </li>
                    <li class="filter-search__item">
                        <div class=" filter-search__dropdown">
                            <a  class="filter-search__link sort-link" href="<?= Url::current(['s' => 'p', 'sd' => ((Yii::$app->request->get('s') == 'p' && Yii::$app->request->get('sd') == 'a') ? 'd' : 'a')]) ?>">
                                <?= Yii::t('frontend', 'By price') ?>
                                <?= (isset($fa_sort_icon['p']) ? $fa_sort_icon['p'] : '') ?>
                            </a>
                        </div>
                    </li>
                    <li class="filter-search__item">
                        <div class=" filter-search__dropdown">
                            <a  class="filter-search__link sort-link" href="<?= Url::current(['s' => 'd', 'sd' => ((Yii::$app->request->get('s') == 'd' && Yii::$app->request->get('sd') == 'd') ? 'a' : 'd')]) ?>">
                                <?= Yii::t('frontend', 'By date') ?>
                                <?= (isset($fa_sort_icon['d']) ? $fa_sort_icon['d'] : '') ?>
                            </a>
                        </div>
                    </li>
                    <!--            <li class="filter-search__item">-->
                    <!--                <div class="dropdown filter-search__dropdown">-->
                    <!--                    <a data-toggle="dropdown" class="filter-search__link" href="#">-->
                    <!--                        Валюта: <span>uzd</span>-->
                    <!--                        <i class="flaticon-download"></i>-->
                    <!--                    </a>-->
                    <!--                    <ul class="filter-search__dropdown-menu dropdown-menu" role="menu" aria-labelledby="dLabel">-->
                    <!--                        <li>-->
                    <!--                            uzd-->
                    <!--                        </li>-->
                    <!--                        <li>-->
                    <!--                            uzd-->
                    <!--                        </li>-->
                    <!--                        <li>-->
                    <!--                            uzd-->
                    <!--                        </li>-->
                    <!--                    </ul>-->
                    <!--                </div>-->
                    <!--            </li>-->
                </ul>
                <!--        <div class="position-result">-->
                <!--            <ul class="position-result__list">-->
                <!--                <li class="position-result__item active">-->
                <!--                    <i class="flaticon-menu"></i>-->
                <!--                </li>-->
                <!--                <li class="position-result__item">-->
                <!--                    <i class="flaticon-lists"></i>-->
                <!--                </li>-->
                <!--            </ul>-->
                <!--        </div>-->
            </div>
            <div class="product-list clearfix">
                <?php
                $bc = 0;
                for ($i = 0; $i < count($products); $i++) { ?>
                    <div class="product-list__item">
                        <a href="<?=Url::to(['product/index', 'id' => $products[$i]->url])?>" data-pjax="0" class="product-list__link"></a>
                        <img src="<?= $products[$i]->mainImage->image ?>" class="product-list__img">
                        <div class="product-list__block">
                            <h3 class="product-list__heading" >
                                <?= $products[$i]->translate->name ?>
                            </h3>
                            <p class="product-list__price">
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
                            </p>

                            <?php if (!empty($products[$i]->activeOptions)) {
                                $loop = 1; ?>
                                <div class="product-list__info">
                                    <div class="row">
                                        <?php foreach ($products[$i]->activeOptions as $option) {
                                        if ($option->option->group->main == 0) continue;
                                        ?>
                                        <div class="col-md-6">
                                            <?= $option->option->translate->name ?>
                                        </div>
                                        <?php if($loop % 2 == 0) { ?>
                                    </div>
                                    <div class="row">
                                        <?php } ?>
                                        <?php $loop++; } ?>
                                    </div>
                                    <?=($products[$i]->km > 0)? number_format($products[$i]->km, 0, '', ' ').' '.Yii::t('frontend','km'):''?>
                                </div>
                            <?php } ?>
                            <p class="product-list__time">
                                <?php
                                if($products[$i]->user_id) {
                                    $city_name = $products[$i]->user->city->translate->name;
                                } else {
                                    $cities = json_decode($products[$i]->shop->cities);
                                    $city_name = '';
                                    if (!empty($cities)) {
                                        foreach ($cities as $city) {
                                            $db_city = \common\models\City::findOne(['id' => $city, 'status' => 1]);
                                            if($db_city) {
                                                $city_name .= $db_city->translate->name.', ';
                                            }
                                        }
                                        $city_name = mb_substr($city_name, 0, -2);
                                    }
                                }
                                ?>
                                <?= ($city_name)? $city_name.',': '' ?> <?= date('d.m.Y H:i', $products[$i]->created_at) ?>
                            </p>
                            <div class="product-lis__like-icon">
                                <?php if($products[$i]->brand && $products[$i]->brand->logo != '/uploads/site/default_cat.png') { ?>
                                    <img src="<?=$products[$i]->brand->logo?>" alt="." class="brand_logo_on_product">
                                <?php } ?>
                                <?php if (in_array($products[$i]->id, $product_ids)) { ?>
                                    <button class="btn add_fav" style="background: #d91b30;" data-prod-id="<?=$products[$i]->id?>" data-action="remove">
                                        <i class="flaticon-like " style="color: #fff"></i>
                                    </button>
                                <?php } else { ?>
                                    <button class="btn add_fav" style="background: transparent;" data-prod-id="<?=$products[$i]->id?>" data-action="add">
                                        <i class="flaticon-like " ></i>
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php if(($i + 1) % 5 == 0) { ?>
                        <div class="mobile_banner__item hidden-md hidden-sm hidden-lg">
                            <?php if ($banners[$bc]->translate->url != '') { ?> <a href="<?=Url::to(['site/away', 'url' => $banners[$bc]->translate->url])?>" target="_blank"> <?php } ?>
                                <img src="<?=$banners[$bc]->translate->image?>" class="mobile_banner__item img-responsive" title="<?=$banners[$bc]->translate->name?>">
                                <?php if ($banners[$bc]->translate->url != '') { ?> </a> <?php } ?>
                        </div>
                        <?php $bc++;} ?>
                <?php } ?>
            </div>
            <div class="pagination-block">
                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                ]); ?>
            </div>
        <?php } ?>

    </section>


<?php Pjax::end() ?>