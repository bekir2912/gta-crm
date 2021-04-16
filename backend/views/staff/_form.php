<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use  yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'FIO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model,'birthday')->widget(DatePicker::className(),
    [
        'dateFormat' => 'yyyy-MM-dd'
    ]) ?>



    <?= $form->field($model, 'salary')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ '0' => 'Уволен', '1' => 'Активен', '2' => 'В отпуске' ]) ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'images')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Доавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
