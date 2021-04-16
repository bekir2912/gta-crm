<?php

use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

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
                            <?= $form->field($info, 'short[ru]')->textarea(['value' => $info->short, 'style' => 'resize: vertical;']) ?>
                        </div>
                        <div class="col-md-6">
                            <?php $fileinput_options = ['accept' => 'image/*', 'multiple' => false/*, 'required' => 'required'*/];
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
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($info, 'text[ru]')->widget(TinyMce::className(), [
                                'options' => ['rows' => 10 , 'value' => $info->text],
                                'language' => 'ru',
                                'clientOptions' => [
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                ]
                            ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($info, 'meta_title[ru]')->textInput(['value' => $info->meta_title]) ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?= $form->field($info, 'meta_description[ru]')->textarea(['value' => $info->meta_description, 'style' => 'resize: vertical;']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($info, 'meta_keys[ru]')->textarea(['value' => $info->meta_keys, 'style' => 'resize: vertical;']) ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_uz">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_uz, 'name[uz]')->textInput(['value' => $info_uz->name]) ?>
                            <?= $form->field($info_uz, 'short[uz]')->textarea(['value' => $info_uz->short, 'style' => 'resize: vertical;']) ?>
                        </div>
                        <div class="col-md-6">
                            <?php $fileinput_options_1 = ['accept' => 'image/*', 'multiple' => false];
                            if ($info_uz->image != '') {
                                $fileinput_options_1 = ['accept' => 'image/*', 'multiple' => false];
                                ?>
                                <img src="<?= $info_uz->image ?>" alt="<?= $info_uz->image ?>" class="img-responsive">
                            <?php } ?>
                            <?= $form->field($info_uz, 'image[uz]')->widget(FileInput::classname(), [
                                'options' => $fileinput_options_1,
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
                        <div class="col-md-12">
                            <?= $form->field($info_uz, 'text[uz]')->textInput(['value' => $info_uz->text])->widget(TinyMce::className(), [

                                'options' => ['rows' => 10 , 'value' => $info_uz->text],
                                'language' => 'ru',
                                'clientOptions' => [
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                ]
                            ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($info_uz, 'meta_title[uz]')->textInput(['value' => $info_uz->meta_title]) ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?= $form->field($info_uz, 'meta_description[uz]')->textarea(['value' => $info_uz->meta_description, 'style' => 'resize: vertical;']) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($info_uz, 'meta_keys[uz]')->textarea(['value' => $info_uz->meta_keys, 'style' => 'resize: vertical;']) ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_oz">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_oz, 'name[oz]')->textInput(['value' => $info_oz->name]) ?>
                            <?= $form->field($info_oz, 'short[oz]')->textarea(['value' => $info_oz->short, 'style' => 'resize: vertical;']) ?>
                        </div>
                        <div class="col-md-6">
                            <?php $fileinput_options_1 = ['accept' => 'image/*', 'multiple' => false];
                            if ($info_oz->image != '') {
                                $fileinput_options_1 = ['accept' => 'image/*', 'multiple' => false];
                                ?>
                                <img src="<?= $info_oz->image ?>" alt="<?= $info_oz->image ?>" class="img-responsive">
                            <?php } ?>
                            <?= $form->field($info_oz, 'image[oz]')->widget(FileInput::classname(), [
                                'options' => $fileinput_options_1,
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
                        <div class="col-md-12">
                            <?= $form->field($info_oz, 'text[oz]')->textInput(['value' => $info_oz->text])->widget(TinyMce::className(), [

                                'options' => ['rows' => 10 , 'value' => $info_oz->text],
                                'language' => 'ru',
                                'clientOptions' => [
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                ]
                            ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($info_oz, 'meta_title[oz]')->textInput(['value' => $info_oz->meta_title]) ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?= $form->field($info_oz, 'meta_description[oz]')->textarea(['value' => $info_oz->meta_description, 'style' => 'resize: vertical;']) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($info_oz, 'meta_keys[oz]')->textarea(['value' => $info_oz->meta_keys, 'style' => 'resize: vertical;']) ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_en">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_en, 'name[en]')->textInput(['value' => $info_en->name]) ?>
                            <?= $form->field($info_en, 'short[en]')->textarea(['value' => $info_en->short, 'style' => 'resize: vertical;']) ?>
                        </div>
                        <div class="col-md-6">
                            <?php $fileinput_options_2 = ['accept' => 'image/*', 'multiple' => false];
                            if ($info_en->image != '') {
                                $fileinput_options_2 = ['accept' => 'image/*', 'multiple' => false];
                                ?>
                                <img src="<?= $info_en->image ?>" alt="<?= $info_en->image ?>" class="img-responsive">
                            <?php } ?>
                            <?= $form->field($info_en, 'image[en]')->widget(FileInput::classname(), [
                                'options' => $fileinput_options_2,
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
                        <div class="col-md-12">
                            <?= $form->field($info_en, 'text[en]')->textInput(['value' => $info_en->text])->widget(TinyMce::className(), [

                                'options' => ['rows' => 10 , 'value' => $info_en->text],
                                'language' => 'ru',
                                'clientOptions' => [
                                    'plugins' => [
                                        "advlist autolink lists link charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                ]
                            ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($info_en, 'meta_title[en]')->textInput(['value' => $info_en->meta_title]) ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?= $form->field($info_en, 'meta_description[en]')->textarea(['value' => $info_en->meta_description, 'style' => 'resize: vertical;']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($info_en, 'meta_keys[en]')->textarea(['value' => $info_en->meta_keys, 'style' => 'resize: vertical;']) ?>
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
            <?= $form->field($model, 'url')->textInput() ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Активен', '0' => 'Не активен']) ?>
        </div>
    </div>

    <div class="form-group">
        <a href="<?= Url::to(['news/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
