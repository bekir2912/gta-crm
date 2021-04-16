<?php
/**
 * Created by PhpStorm.
 * User: lexcorp
 * Date: 01.04.2018
 * Time: 17:45
 */

use common\models\Category;
use yii\helpers\Url;

use frontend\widgets\WCategory;

$this->registerCss("
    .cities_dropdown>li>a {
        padding: 9px 15px;
    }
");

$currency = Yii::$app->session->get('currency', 'uzs');
if(Yii::$app->request->get('currency', '') == 'uzs' || Yii::$app->request->get('currency', '') == 'usd') {
    $currency = Yii::$app->request->get('currency', Yii::$app->session->get('currency', 'uzs'));
    Yii::$app->session->set('currency', $currency);
    Yii::$app->response->redirect(Url::current(['currency' => '']));
}

$root_cat = Yii::$app->session->get('root_category');
$root_category = Category::find()->where(['id' => $root_cat, 'status' => 1, 'parent_id' => null])->orderBy('order')->one();
$page = Yii::$app->session->get('page');
$city_id = Yii::$app->session->get('city_id');

if ($city_id) {
    $city = \common\models\City::find()->where(['status' => 1, 'id' => $city_id])->orderBy('`order` ASC')->one();
}
$cities = \common\models\City::find()->where(['status' => 1])->orderBy('`order` ASC')->all();
?>

<header class="header">
    <div class="container">
        <div class="logo__block">
            <a href="<?=Url::to(['/'])?>" class="logo__link">
                <img src="/uploads/site/logo_red.png" alt="<?= Yii::$app->params['appName'] ?>" class="logo__image">
            </a>
        </div>
        <nav class="navigation">
            <button class="navigaton__exit-button">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
            <?= WCategory::widget(['key' => 'menu']); ?>
        </nav>
        <button class="header__button_menu">
            <i class="flaticon-lists header__search-icon"></i>
        </button>
    </div>
    <div class="submenu">
        <div class="container">
            <div class="button-group">
                <div class="button-group__item dropdown">
                    <a class="#" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false" style="text-transform: uppercase; color: inherit!important;cursor: pointer;">
<!--                        <span class="fa fa-dollar"></span>-->
                        <?=Yii::t('frontend', $currency)?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right cities_dropdown" aria-labelledby="dropdownMenu1" style="min-width: auto;">
                        <li style="text-transform: uppercase;"><a href="<?=Url::current(['currency' => 'uzs'])?>"><?=Yii::t('frontend', 'uzs')?></a></li>
                        <li style="text-transform: uppercase;"><a href="<?=Url::current(['currency' => 'usd'])?>"><?=Yii::t('frontend', 'usd')?></a></li>
                    </ul>
                </div>
                <?php if($page == 'cabinet') { ?>
                    <div class="button-group__item">
                        <a href="<?=Url::to(['balance/fill'])?>" style="color: inherit;">
                            <span class="flaticon-wallet"></span>
                            <span class="button-group__text">
                            <?=Yii::$app->getUser()->identity->balance?> <?=Yii::t('frontend', 'uzs')?>
                        </span>
                            <span class="flaticon-plus-1"></span>
                        </a>
                    </div>
                <?php } else if($page == 'category' || $page == 'shops' || $page == 'radars' || $page == 'services') { ?>
                    <div class="button-group__item dropdown">
                        <a class="#" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: inherit!important;;">
                            <span class="flaticon-pin"></span>
                            <span class="button-group__text pointer">
                            <?=Yii::t('frontend', 'Search in')?>
                                <i class="link_span">
                                <?=($city)? $city->translate->name: Yii::t('frontend', 'All cities')?>
                            </i>
                        </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right cities_dropdown" aria-labelledby="dropdownMenu1">
                            <li><a href="<?=Url::current(['city_id' => 'all'])?>"><?=Yii::t('frontend', 'All cities');?></a></li>
                            <?php foreach ($cities as $city) { ?>
                                <li><a href="<?=Url::current(['city_id' => $city->id])?>"><?=$city->translate->name?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } else if ($page == 'product' || $page == 'shop') { ?>
                    <div class="button-group__item dropdown">
                        <a href="<?=Url::to(['category/index', 'id' => $root_category->url, 'city_id' => ($city)? $city->id:'all'])?>" type="button" style="color: inherit!important;;">
                            <span class="flaticon-pin"></span>
                            <span class="button-group__text pointer">
                            <?=Yii::t('frontend', 'Search in')?>
                                <i class="link_span">
                                <?=($city)? $city->translate->name: Yii::t('frontend', 'All cities')?>
                            </i>
                        </span>
                        </a>
                    </div>
                <?php } ?>
                <div class="button-group__item">
                    <a href="<?= Url::to(['favorite/index']) ?>" class="button-group__link">
                        <span class="flaticon-like"></span>
                        <span class="button-group__text">
                                <?= Yii::t('frontend', 'Favorites') ?>
                            </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>