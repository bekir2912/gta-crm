<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Seller */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seller-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
        <div class="form-group ">
            <label class="control-label" >Логин</label>
            <p style="padding-left: 10px;" class="text-secondary"><?=$model->username?></p>
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'name')->textInput() ?></div>
    </div>
    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'phone')->textInput() ?></div>
    </div>
    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'ucard')->textInput() ?></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <h4>
                Изменить пароль
            </h4>
            <?= $form->field($model, 'password')->passwordInput() ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
