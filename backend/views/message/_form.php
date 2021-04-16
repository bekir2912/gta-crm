<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SourceMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="source-message-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#perf_ru" aria-controls="perf_ru" role="tab"
                                                          data-toggle="tab">Русский</a></li>
                <li role="presentation"><a href="#perf_uz" aria-controls="perf_uz" role="tab" data-toggle="tab">Узбекский</a>
                </li>
                <li role="presentation"><a href="#perf_oz" aria-controls="perf_oz" role="tab" data-toggle="tab">Oz'bekcha</a>
                </li>
                <li role="presentation"><a href="#perf_en" aria-controls="perf_en" role="tab" data-toggle="tab">Английский</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="perf_ru">
                    <p></p>
                    <?= $form->field($model, 'translation[ru]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model->translation]) ?>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_uz">
                    <p></p>
                    <?= $form->field($model_uz, 'translation[uz]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model_uz->translation]) ?>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_oz">
                    <p></p>
                    <?= $form->field($model_oz, 'translation[oz]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model_oz->translation]) ?>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_en">
                    <p></p>
                    <?= $form->field($model_en, 'translation[en]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model_en->translation]) ?>
                </div>
            </div>
            </div>
            </div>




    <div class="form-group">
        <a href="<?= Url::to(['message/index',]) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>