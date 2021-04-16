<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel store\models\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Boost');

?>

<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <strong><?= $this->title ?></strong>
        </div>
    </div>
    <div class="col-md-12">
        <div class="news_body">
            <h4 style="margin-bottom: 35px;">
                <?=Yii::t('frontend', 'Boost announcement')?>: <strong><?=$product->translate->name?></strong>
            </h4>
            <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['announcement/boost', 'id' => $product->id]), 'method' => 'post'])?>
            <div class="checkbox" style="margin-bottom: 25px;">
                <label class="premium_offers">
                    <input type="checkbox" name="colored_offer" value="1">
                    <i class="fa fa-paint-brush" style="margin-right: 10px; vertical-align: middle;font-size: 25px;color: #6e7bfe"></i> <?=Yii::t('frontend', 'Colored offer')?> - <?=number_format(Yii::$app->params['boost_price']['colored_offer']['price'], 0, '', ' ')?> <?=Yii::t('frontend', 'uzs')?> (<?=Yii::$app->params['boost_price']['colored_offer']['days']?> <?=Yii::t('frontend', 'days')?>)
                </label>
            </div>
            <div class="checkbox" style="margin-bottom: 25px;">
                <label class="premium_offers">
                    <input type="checkbox" name="special_offer" value="1">
                    <i class="fa fa-star" style="margin-right: 10px; vertical-align: middle;font-size: 25px;color: #ffc720;"></i> <?=Yii::t('frontend', 'Special offer')?> - <?=number_format(Yii::$app->params['boost_price']['special_offer']['price'], 0, '', ' ')?> <?=Yii::t('frontend', 'uzs')?> (<?=Yii::$app->params['boost_price']['special_offer']['days']?> <?=Yii::t('frontend', 'days')?>)
                </label>
            </div>
            <button class="btn btn-primary"><?=Yii::t('frontend', 'Promote')?></button>
            <?php ActiveForm::end()?>
        </div>
    </div>
</div>