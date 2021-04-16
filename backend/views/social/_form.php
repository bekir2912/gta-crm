<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Social */
/* @var $form yii\widgets\ActiveForm */

$icons = [
    'facebook-official',
    'facebook-square',
    'facebook',
    'google-plus-official',
    'google-plus-square',
    'google-plus',
    'instagram',
    'odnoklassniki-square',
    'odnoklassniki',
    'telegram',
    'twitter-square',
    'twitter',
    'vk',
    'youtube-square',
    'youtube',
    'youtube-play',
];

?>

<div class="social-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 col-md-8">
            <p>
                <strong>Выберите иконку</strong>
            </p>
            <div class="row">
            <?php $it = 0; foreach ($icons as $icon) { ?>
                <div class="col-xs-2">
                <div class="radio">
                    <label for="<?=$icon?>">
                        <input type="radio" name="Social[icon]" value="<?=$icon?>" id="<?=$icon?>" required="required"
                        <?php if($model->icon != '' && $model->icon == $icon) { ?>checked="checked"<?php } elseif($model->icon == '' && $it == 0) { ?>checked="checked"<?php } ?>> <?=FA::i($icon)->size('2x')?>
                    </label>
                </div>
                </div>
            <?php $it++;} ?>
            </div>
        </div>
    </div>
    <p></p>
    <div class="separator"></div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'order')->textInput(['value' => ($model->order != '')? $model->order: 0]) ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Активен', '0' => 'Не активен']) ?>
        </div>
    </div>

    <div class="form-group">
        <a href="<?= Url::to(['social/index']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
