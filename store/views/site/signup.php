<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Подать заявку';
?>

<div class="white-block">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header text-center"><?= Html::encode($this->title) ?></div>
        </div>
        <div class="col-md-12">
            <div class="news_body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('frontend', 'Phone placeholder')]) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Подать заявку', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>