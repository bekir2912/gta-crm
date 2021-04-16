<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SourceMessage */

$this->title = $model->translation;
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="sale-create">
                    <div class="page-header"><?= Html::encode($this->title) ?></div>
                    <p></p>
                    <?= $this->render('_form', [
                        'model' => $model,
                        'model_uz' => $model_uz,
                        'model_oz' => $model_oz,
                        'model_en' => $model_en,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
