<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>
    <?php if($model->id != Yii::$app->user->id) { ?>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'status')->dropDownList(['10' => 'Активен', '0' => 'Заблокирован']) ?>
        </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <a href="<?= Url::to(['admin/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
