<?php

use common\models\Category;
use kartik\file\FileInput;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */

if ($model->id > 0) {
    $cats = Category::find()->where(['parent_id' => null])->andWhere('`id` != ' . $model->id)->all();
} else $cats = Category::find()->where(['parent_id' => null])->all();

$cat_filter[] = 'Без родителя';
$cat_options = [];
if (!empty($cats)) {
    foreach ($cats as $cat) {
        if ($model->id == $cat->id) continue;
        $cat_filter[$cat->id] = $cat->translate->name;
        if ($cat->categories) {
            $cat_filter = ArrayHelper::merge($cat_filter, getCategoryChild($cat->categories, $model));
            $cat_options = ArrayHelper::merge($cat_options, getCategoryOptions($cat->categories, $model));
        }
    }
}
function getCategoryChild($cat, $model, $index = 1)
{
    $result = [];
    $prefix = '';
    for ($i = 0; $i < $index; $i++) {
        $prefix .= '-';
    }
    $style = false;
    if ($index == 1) $style = 'bold';
    foreach ($cat as $item) {
        if ($model->id == $item->id) continue;
        if ($style) $result[$item->id] = $prefix . $item->translate->name;
        else $result[$item->id] = $prefix . $item->translate->name;
        if ($item->categories) {
            $result = ArrayHelper::merge($result, getCategoryChild($item->categories, $model, $index + 1));
        }
    }
    return $result;
}
function getCategoryOptions($cat, $model, $index = 1)
{
    $result = [];
    foreach ($cat as $item) {
        if ($model->id == $item->id) continue;
        $result[$item->id] =  ['style' => 'font-weight: bold;'];
    }
    return $result;
}

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'parent_id')->dropDownList($cat_filter, ['options' => $cat_options]) ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?php $fileinput_options = ['accept' => 'image/*', 'multiple' => false];
            if ($model->icon != '') {
                $fileinput_options = ['accept' => 'image/*', 'multiple' => false];
                ?>
                <img src="<?= $model->icon ?>" alt="<?= $model->icon ?>" class="img-responsive">
            <?php } ?>
                <?= $form->field($model, 'icon')->widget(FileInput::classname(), [
                    'options' => $fileinput_options,
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' => 'Выбрать Иконку'
                    ],
                    'language' => 'ru'
                ]); ?>
        </div>
        <div class="clearfix"></div>
        <p></p>
        <div class="separator"></div>
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
                                <?= $form->field($info, 'description[ru]')->textarea(['value' => $info->description, 'style' => 'resize: vertical;']) ?>
                            </div>
                            <div class="col-md-6">
                                <?php $fileinput_options = ['accept' => 'image/*', 'multiple' => false];
                                if ($info->image != '') {
                                    $fileinput_options = ['accept' => 'image/*', 'multiple' => false];
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane " id="perf_uz">
                        <p></p>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($info_uz, 'name[uz]')->textInput(['value' => $info_uz->name]) ?>
                                <?= $form->field($info_uz, 'description[uz]')->textarea(['value' => $info_uz->description, 'style' => 'resize: vertical;']) ?>
                            </div>
                            <div class="col-md-6">
                                <?php if ($info_uz->image != '') { ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane " id="perf_oz">
                        <p></p>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($info_oz, 'name[oz]')->textInput(['value' => $info_oz->name]) ?>
                                <?= $form->field($info_oz, 'description[oz]')->textarea(['value' => $info_oz->description, 'style' => 'resize: vertical;']) ?>
                            </div>
                            <div class="col-md-6">
                                <?php if ($info_oz->image != '') { ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane " id="perf_en">
                        <p></p>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($info_en, 'name[en]')->textInput(['value' => $info_en->name]) ?>
                                <?= $form->field($info_en, 'description[en]')->textarea(['value' => $info_en->description, 'style' => 'resize: vertical;']) ?>
                            </div>
                            <div class="col-md-6">
                                <?php if ($info_en->image != '') { ?>
                                <?php } ?>
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
                <?= $form->field($model, 'on_main')->checkbox() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <?= $form->field($model, 'spec')->checkbox() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <?= $form->field($model, 'order')->textInput(['value' => ($model->order != '') ? $model->order : 0]) ?>
            </div>
            <div class="col-sm-6 col-md-4">
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Активен', '0' => 'Не активен']) ?>
            </div>
        </div>
        <div class="form-group">
            <a href="<?= Url::to(['category/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if(!$model->isNewRecord) { ?>
                <a href="<?= Url::to(['category/create']) ?>" class="btn btn-success btn-cancel">Добавить еще</a>
            <?php } ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php $this->registerJs('
    $(document).ready(function() {
        $(\'select.form-control\').select2(
            {
                language: {
                  noResults: function () {
                    return "Ничего не найдено";
                  }
                }
            }
        );
    });
    $(document).on(\'ready pjax:success\', function() {
        $(\'select.form-control\').select2(
            {
                language: {
                  noResults: function () {
                    return "Ничего не найдено";
                  }
                }
            }
        );
    });
');?>