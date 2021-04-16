<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = 'Информация компании: '.$model->name;
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
<div class="shop-update">

    <div class="page-header">
        <?= Html::encode($model->name) ?> <span class="text-muted">|</span>
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
        'info_uz' => $info_uz,
        'info_oz' => $info_oz,
        'info_en' => $info_en,
    ]) ?>

</div>
</div>
</div>
</div>
</div>
