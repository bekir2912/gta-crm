<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('frontend', 'Sign Up');
?>

    <div class="row">
        <div class="col-md-12">
            <div class="page-header text-center"><?= Html::encode($this->title) ?></div>
        </div>
        <div class="col-sm-6 col-sm-offset-3 ">
            <div class="news_body">
                                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                                <?= $form->field($model, 'name') ?>
                                <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('frontend', 'Phone placeholder')]) ?>
                                <div class="form-group text-center">
                                    <?= Html::submitButton(Yii::t('frontend', 'Sign Up'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                <div class="separator"></div>
                <div class="text-center">
                    <?= Html::a(Yii::t('frontend', 'Sign In'), ['site/login']) ?>
                </div>
            </div>
        </div>
    </div>
