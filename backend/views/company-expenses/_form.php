<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyExpenses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-expenses-form">

    <?php $form = ActiveForm::begin(); ?>

    <div div class="row">   
        <div class="col-sm-6 col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6 col-md-6">
        <?= $form->field($model, 'status')->dropDownList(["1" => "Активен", "0" => "Не активен"]) ?>
        </div>
    </div>
    <div div class="row">  
    
        <div class="col-md-12">
            <?= $form->field($model, 'discription')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model->discription]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'добавить' : 'изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
