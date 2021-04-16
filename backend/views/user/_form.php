<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Seller */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

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
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'ucard')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'balance')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <?= $form->field($model, 'status')->dropDownList(['10' => 'Активен', '0' => 'Заблокирован']) ?>
            </div>
        </div>
    <div class="form-group">
        <a href="<?= Url::to(['user/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
