<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Social */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="social-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'rating')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]) ?>
            <?= $form->field($model, 'comment')->textarea() ?>
            <?= $form->field($model, 'status')->dropDownList(['0' => 'Заблокирован', '1' => 'Опубликован']) ?>
        </div>
    </div>

    <div class="form-group">
        <a href="<?= Url::to(['review/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
