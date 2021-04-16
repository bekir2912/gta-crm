<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel store\models\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Fill balance');

?>

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <strong><?= $this->title ?></strong>
            </div>
        </div>
        <div class="col-md-12">
            <div class="news_body">
                <form action="#">
                    <?php for($i = 0; $i < count(Yii::$app->params['balance_fill']); $i++) { ?>
                        <div class="radio">
                            <label style="text-transform: none;">
                                <input type="radio" name="sum" <?=($i == 0)? 'checked': ''?> value="<?=Yii::$app->params['balance_fill'][$i] * 100 ?>"> <?=number_format(Yii::$app->params['balance_fill'][$i], 0, '', ' ')?> <?=Yii::t('frontend', 'uzs')?>
                            </label>
                        </div>
                    <?php } ?>
                    <button class="btn btn-primary"><?=Yii::t('frontend', 'Fill')?></button>
                </form>
            </div>
        </div>
    </div>
