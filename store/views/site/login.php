<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>
<div class="white-block">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header text-center"><?= Html::encode($this->title) ?></div>
        </div>
        <div class="col-md-12">
            <div class="news_body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('frontend', 'Phone placeholder')]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="pull-left">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <div class="pull-right">
                    <?= Html::a('Забыли пароль', ['site/request-password-reset'], ['style' => 'margin-top: 10px;display: inline-block;']) ?>
                </div>

                <div class="clearfix"></div>

                <div class="form-group text-center">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                <div class="separator"></div>
                <div class="text-center">
                    <?= Html::a('Подать заявку', ['site/signup']) ?>
                </div>
            </div>
        </div>
    </div>
</div>