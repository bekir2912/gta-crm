<?php

use common\models\Category;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel store\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Announce');


$this->registerJs('
    $(function () {
      $(\'[data-toggle="tooltip"]\').tooltip()
    })
');

$cats = Category::find()->where(['status' => 1, 'parent_id' => null, 'on_main' => 0])->orderBy('order')->all();

$currency = Yii::$app->session->get('currency', 'uzs');
use common\widgets\Alert;
?>

<section class="announcements">

    <?= Alert::widget() ?>
    <?php if (!empty($cats)) { ?>
        <div class="announcements__category">
            <ul class="category__list">
                <li class="category__item">
                    <a href="<?= Url::current(['cat_id' => '']) ?>"
                       class="category__link <?= (!$filter_cat) ? ' category__link--active' : '' ?>">
                        <?= Yii::t('frontend', 'All Announces') ?>
                    </a>
                </li>
                <?php foreach ($cats as $cat) { ?>
                    <li class="category__item">
                        <a href="<?= Url::current(['cat_id' => $cat->id]) ?>"
                           class="category__link <?= ($filter_cat && ($filter_cat->id == $cat->id)) ? ' category__link--active' : '' ?>">
                            <?= $cat->translate->name ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <div class="product-list">
        <?php if (!empty($announces)) { ?>
        <?php foreach ($announces

        as $announce) {

                if($currency == 'usd') {
                    $announce->price = $announce->price_usd;
                    $announce->wholesale = $announce->wholesale_usd;
                }
            ?>
        <div class="product-list__item">
            <div class="announcements__edit">
                <img src="<?= $announce->mainImage->image ?>" class="product-list__img">
                <ul class="announcements__button-list">
                    <li class="announcements__button-item">
                        <a data-toggle="tooltip" data-placement="top" title="<?=Yii::t('frontend', 'Edit')?>" href="<?= Url::to(['announcement/update', 'id' => $announce->id, 'category' => $announce->category_id, 'brand' => $announce->brand_id, 'lineup' => $announce->lineup_id]) ?>"
                           class="announcements__button">
                            <i class="flaticon-edit"></i>
                        </a>
                    </li>
                    <li class="announcements__button-item">
                        <a data-toggle="tooltip" data-placement="top" title="<?=Yii::t('frontend', 'Delete')?>" href="<?= Url::to(['announcement/delete', 'id' => $announce->id]) ?>" data-pjax="0" onclick="if(!confirm('<?=Yii::t('frontend', 'Confirm deleting');?>')) return false;"
                           class="announcements__button">
                            <i class="flaticon-garbage"></i>
                        </a>
                    </li>
                    <li class="announcements__button-item" >
                        <a data-toggle="tooltip" data-placement="top" title="<?=Yii::t('frontend', 'Boost')?>" href="<?= Url::to(['announcement/boost', 'id' => $announce->id]) ?>" data-pjax="0" class="announcements__button <?=($announce->colored_offer > time())? 'announcements__button-active':'' ?>">
                            <i class="flaticon-startup"></i>
                        </a>
                    </li>
                    <li data-prod="<?=$announce->id?>" data-status="<?=($announce->status != 1)? '1': '0'?>" class="announcements__button-item announcements__button-switch <?=($announce->status != 1)? 'announcements__button-item-not-active': ''?>">
                        <a data-toggle="tooltip" data-placement="top" title="<?=Yii::t('frontend', 'Switch on')?>" class="announcements__button">
                            <i class="flaticon-power-button"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="product-list__block">
                <h3 class="product-list__heading">
                    <?= $announce->translate->name ?>
                </h3>
                <p class="product-list__price">
                <?php if ($announce->price_type == 0) {
                    $wholesales = json_decode($announce->wholesale);
                    ?>
                    <?php if ($announce->price == 0) { ?>
                        <?= Yii::t('frontend', 'Specify prices from the seller') ?>
                    <?php } else { ?>
                        <?= $announce->showPrice ?>
                    <?php } ?>
                <?php } elseif ($announce->price_type == 1) {
                    $wholesales = json_decode($announce->wholesale);
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
                <?php } elseif ($announce->price_type == 2) {
                    $wholesales = json_decode($announce->wholesale);
                    ?>
                    <?php if ($announce->price == 0) { ?>
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
                        <?= $announce->showPrice ?>
                    <?php } ?>
                <?php } ?>
            </p>

                <?php if (!empty($announce->activeOptions)) {
                    $loop = 1; ?>
                    <div class="product-list__info">
                        <div class="row">
                            <?php foreach ($announce->activeOptions as $option) {
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
                        <?=($announce->km > 0)? number_format($announce->km, 0, '', ' ').' '.Yii::t('frontend','km'):''?>
                    </div>
                <?php } ?>
            <p class="product-list__time">
                <?= $announce->user->city->translate->name ?>, <?= date('d.m.Y H:i', $announce->created_at) ?>
            </p>
            <div class="announcements-bottom-info">
                <p>
                    <?= Yii::t('frontend', 'Views') ?>:
                    <span>
                        <?= $announce->view ?>
                                            </span>
                </p>
                <p>
                    <?= Yii::t('frontend', 'Phone views') ?>:
                    <span>
                            <?= $announce->phone_views ?>
                        </span>
                </p>
            </div>
                <div class="clearfix"></div>
                <p></p>
                <div class="row">
                    <div class="col-md-12" style="font-size: 13px;">
                        <?php if($announce->colored_offer > time()) { ?>
                            <div class="text-success" >
                                <?=Yii::t('frontend', 'Activated boost')?> <strong>"<i class="fa fa-paint-brush" style="color: #6e7bfe"></i> <?=Yii::t('frontend', 'Colored offer')?>"</strong> <?=mb_strtolower(Yii::t('frontend', 'To'))?> <?=date('d.m.Y H:i', $announce->colored_offer)?>
                            </div>
                        <?php } ?>
                        <?php if($announce->special_offer > time()) { ?>
                            <div class="text-success" >
                                <?=Yii::t('frontend', 'Activated boost')?> <strong>"<i class="fa fa-star" style="color: #ffc720"></i> <?=Yii::t('frontend', 'Special offer')?>"</strong> <?=mb_strtolower(Yii::t('frontend', 'To'))?> <?=date('d.m.Y H:i', $announce->special_offer)?>
                            </div>
                        <?php } ?>
                        <?php if($announce->status == 0) { ?>
                            <div class="text-danger" >
                                  <strong><?=Yii::t('frontend', 'Announce is turned off')?></strong>
                            </div>
                        <?php } ?>
                        <?php if($announce->status == -1) { ?>
                            <div class="text-danger" >
                                  <strong><?=Yii::t('frontend', 'Blocked')?></strong>
                            </div>
                        <?php } ?>
                    </div>
                </div>
        </div>
    </div>
<?php } ?>
<?php } ?>
    </div>
    <div class="clearfix add-announcement-block">
        <div>
            <?= LinkPager::widget([
                'pagination' => $pagination,
            ]); ?>
        </div>
        <a href="<?= Url::to(['announcement/create']) ?>" class="add-announcement">
            <i class="flaticon-plus"></i>
            <?= Yii::t('frontend', 'Add announce') ?>
        </a>
    </div>
</section>