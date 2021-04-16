<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Shop */
/* @var $info common\models\ShopAddresses */

$this->title = 'Добавить компанию';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="shop-create">

                    <div class="page-header"><?= Html::encode($this->title) ?></div>
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
