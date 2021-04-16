<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = 'Информация компании: '.$model->name;
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
<div class="shop-update">

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" >
                <li role="presentation" class="active"><a href="#teb_shop">Компания</a></li>
                <li role="presentation" ><a href="<?=Url::to(['product/index', 'ProductSearch[shop_id]' => $model->id, 'sort' => '-id'])?>">Объявления</a></li>
            </ul>
        </div>
    </div>
    <div class="page-header" id="teb_shop">
        <?= Html::encode($model->name) ?>
        <span class="text-muted">|</span>
        <small  class="text-secondary"><?=FA::i('star')?> <?=$model->rating?></small> <span class="text-muted">|</span>
        <small  class="text-secondary">
            <?=FA::i('eye')?> <?=$model->view?> -
            <span class="text-primary"><?=FA::i('mobile-phone')?> <?=$model->view_phone?></span> -
            <?=FA::i('car')?> <?=$model->view_prods?>
        </small>
    </div>
    <p></p>

    <?= $this->render('_form', [
        'model' => $model,
        'info' => $info,
        'info_oz' => $info_oz,
        'info_uz' => $info_uz,
        'info_en' => $info_en,
    ]) ?>

</div>
</div>
</div>
</div>
</div>
