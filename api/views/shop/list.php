<?php
/* @var $this yii\web\View */


use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = $category->translate->name.'-'.Yii::t('frontend', 'Shops');
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

$banners = \common\models\Banner::find()->where(['status' => 1, 'type' => 1])->andWhere(['>', 'expires_in', time()])->orderBy('order')->limit(5)->all();
?>
<?php if (count($breads) > 1) { ?>
    <div class="bread-crumbs">
        <ul class="bread-crumbs__list">
            <?php for($i = 0; $i < count($breads); $i++) { ?>
                <li class="bread-crumbs__item">
                    <?php if ($i + 1 != count($breads)) { ?>
                    <a href="<?=Url::to(['shop/list', 'id' => $breads[$i]->url])?>" class="bread-crumbs__link">
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
    <div class="SubcategoriesList Subcategories">
        <?php for ($s = 0; $s < count($category->activeCategories); $s++) { ?>
            <div class="SubcategoriesList-item">
                <a class="navigation__dropdown-link" href="<?=Url::to(['shop/list', 'id' => $category->activeCategories[$s]->url])?>"><?=$category->activeCategories[$s]->translate->name?></a>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<?php Pjax::begin()?>
<?php require_once('right.php') ?>
    <section class="result-of-search clearfix" id="search-result">
        <h3 class="result-of-search__heading">
            <?=Yii::t('frontend', 'Found variants')?>:
            <span class="result-of-search--bold">
                                <?=$pagination->totalCount?>
                            </span>
        </h3>

        <?php if (!empty($filtered_shops)) { ?>
            <div class="result-of-search__filter-search" >
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
            <div class="clearfix"></div>
            <div class="diller-cars clearfix">
                <?php
                $bc = 0;
                for ($i = 0; $i < count($filtered_shops); $i++) { ?>
                    <div class="diller-cars__item">
                        <div class="diller-cars__img-block">
                            <a href="<?=Url::to(['shop/index', 'id' => $filtered_shops[$i]->url, 'cat' => $category->url])?>" data-pjax="0" class="diller-cars__link">
                            <img src="<?=$filtered_shops[$i]->logo?>" class="diller-cars__img">
                            </a>
                        </div>
                        <div class="diller-cars__info-block">
                            <h3 class="diller-cars__heading">
                                <a href="<?=Url::to(['shop/index', 'id' => $filtered_shops[$i]->url, 'cat' => $category->url])?>" data-pjax="0" class="diller-cars__link">
                                <?=$filtered_shops[$i]->name?>
                                </a>
                            </h3>

                            <?php if (($filtered_shops[$i]->info->phone != '')) { ?>
                                <button class="diller-cars__phone-number show_shop_phone" style="border: 0;" data-shop="<?=$filtered_shops[$i]->id?>">
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
                                        <?=isset($shops_products[$filtered_shops[$i]->id])? $shops_products[$filtered_shops[$i]->id]: 0 ?> <?=Yii::t('frontend', 'unit')?>
                                    </span>
                            </p>
                            <a href="<?=Url::to(['shop/index', 'id' => $filtered_shops[$i]->url, 'cat' => $category->url])?>" data-pjax="0" class="diller-cars__link">
                                <?=Yii::t('frontend', 'Show all')?>
                                <i class="flaticon-next"></i>
                            </a>
                            <?php if($filtered_shops[$i]->info->address != '') { ?>
                                <p class="diller-cars__adress">
                                    <?=Yii::t('frontend', 'Address')?>:
                                    <span>
                                        <?=$filtered_shops[$i]->info->address?>
                                    </span>
                                </p>
                            <?php } ?>
                        </div>
                        <!--                        <div class="diller-cars__slider">-->
                        <!--                            <ul class="diller-cars__image-list">-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                                <li class="diller-cars__image-item">-->
                        <!--                                    <a data-fancybox="gallery-1" href="img/img-1.jpg">-->
                        <!--                                        <img src="img/img-2.jpg" class="slide__image">-->
                        <!--                                    </a>-->
                        <!--                                </li>-->
                        <!--                            </ul>-->
                        <!--                        </div>-->
                        <div class="clearfix"></div>
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

<?php Pjax::end()?>