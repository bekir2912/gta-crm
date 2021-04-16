<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(Yii::$app->params['domain'].'/inputmask/jquery.inputmask.bundle.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile(Yii::$app->params['domain'].'/inputmask/inputmask/bindings/inputmask.binding.min.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#perf_ru" aria-controls="perf_ru" role="tab"
                                                          data-toggle="tab">Русский</a></li>
                <li role="presentation"><a href="#perf_uz" aria-controls="perf_uz" role="tab" data-toggle="tab">Узбекский</a>
                </li>
                <li role="presentation"><a href="#perf_oz" aria-controls="perf_oz" role="tab" data-toggle="tab">Oz'bekcha</a>
                </li>
                <li role="presentation"><a href="#perf_en" aria-controls="perf_en" role="tab" data-toggle="tab">Английский</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="perf_ru">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info, 'name[ru]')->textInput(['value' => $info->name]) ?>
                            <?= $form->field($info, 'description[ru]')->hiddenInput()->label(false) ?>
                            <?= $form->field($info, 'url[ru]')->textInput(['value' => $info->url]) ?>
                        </div>
                        <div class="col-md-6">
                            <?php $fileinput_options = ['accept' => 'image/*', 'multiple' => false, 'required' => 'required'];
                            if ($info->image != '') {
                                $fileinput_options = ['accept' => 'image/*', 'multiple' => false];
                                ?>
                                <img src="<?= $info->image ?>" alt="<?= $info->image ?>" class="img-responsive">
                            <?php } ?>
                            <?= $form->field($info, 'image[ru]')->widget(FileInput::classname(), [
                                'options' => $fileinput_options,
                                'pluginOptions' => [
                                    'showCaption' => false,
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' => 'Выбрать Картинку'
                                ],
                                'language' => 'ru'
                            ]); ?>
                            <p class="info">Рекомендуемый размер десктоп: <strong>Ширина - <?=Yii::$app->params['imageSizes']['banners']['image'][0]?>px; Высота - любая</strong></p>
                            <p class="info">Рекомендуемый размер мобильный: <strong>Ширина - 500px; Высота - любая</strong></p>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_uz">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_uz, 'name[uz]')->textInput(['value' => $info_uz->name]) ?>
                            <?= $form->field($info_uz, 'description[uz]')->hiddenInput()->label(false) ?>
                            <?= $form->field($info_uz, 'url[uz]')->textInput(['value' => $info_uz->url]) ?>
                        </div>
                        <div class="col-md-6">
                            <?php if ($info_uz->image != '') { ?>
                                <img src="<?= $info_uz->image ?>" alt="<?= $info_uz->image ?>" class="img-responsive">
                            <?php } ?>
                            <?= $form->field($info_uz, 'image[uz]')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'image/*', 'multiple' => false],
                                'pluginOptions' => [
                                    'showCaption' => false,
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' => 'Выбрать Картинку'
                                ],
                                'language' => 'ru'
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_oz">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_oz, 'name[oz]')->textInput(['value' => $info_oz->name]) ?>
                            <?= $form->field($info_oz, 'description[oz]')->hiddenInput()->label(false) ?>
                            <?= $form->field($info_oz, 'url[oz]')->textInput(['value' => $info_oz->url]) ?>
                        </div>
                        <div class="col-md-6">
                            <?php if ($info_oz->image != '') { ?>
                                <img src="<?= $info_oz->image ?>" alt="<?= $info_oz->image ?>" class="img-responsive">
                            <?php } ?>
                            <?= $form->field($info_oz, 'image[oz]')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'image/*', 'multiple' => false],
                                'pluginOptions' => [
                                    'showCaption' => false,
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' => 'Выбрать Картинку'
                                ],
                                'language' => 'ru'
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_en">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_en, 'name[en]')->textInput(['value' => $info_en->name]) ?>
                            <?= $form->field($info_en, 'description[en]')->hiddenInput()->label(false) ?>
                            <?= $form->field($info_en, 'url[en]')->textInput(['value' => $info_en->url]) ?>
                        </div>
                        <div class="col-md-6">
                            <?php if ($info_en->image != '') { ?>
                                <img src="<?= $info_en->image ?>" alt="<?= $info_en->image ?>" class="img-responsive">
                            <?php } ?>
                            <?= $form->field($info_en, 'image[en]')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'image/*', 'multiple' => false],
                                'pluginOptions' => [
                                    'showCaption' => false,
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' => 'Выбрать Картинку'
                                ],
                                'language' => 'ru'
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <p></p>
    <div class="separator"></div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'expires_in')->textInput(['data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd.mm.yyyy', 'value' => $model->expires_in > 0? date('d.m.Y', $model->expires_in): date('d.m.Y')]) ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'type')->dropDownList(['0' => 'Десктоп', '1' => 'Мобильный']) ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'order')->textInput(['value' => ($model->order != '')? $model->order: 0]) ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Активен', '0' => 'Не активен']) ?>
        </div>
    </div>
    <div class="form-group">
        <a href="<?= Url::to(['banner/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
