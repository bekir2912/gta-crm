<?php

use common\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OptionGroup */
/* @var $form yii\widgets\ActiveForm */

$all_cats = Category::find()->where(['status' => 1, 'parent_id' => null])->all();

function recursiveOptions($all_cats, $index = 0 , $cat_id)
{
    $result = '';
    $prefix = '';
    for ($i = 0; $i < $index; $i++) {
        $prefix .= '-';
    }
    foreach ($all_cats as $cats) {
        if (!empty($cats->activeCategories)) {
            $result .= '<optgroup label="' . $prefix . $cats->translate->name . '">';
            $result .= recursiveOptions($cats->activeCategories, $index + 1, $cat_id);
            $result .= '</optgroup>';
        } else {
            $class = ($cat_id == $cats->id)? 'selected="selected"': '';
            $result .= '<option value="' . $cats->id . '" '.$class.'>' . $prefix . $cats->translate->name . '</option>';
        }
    }
    return $result;
}
$cats_formed = recursiveOptions($all_cats, 0, $model->category_id);
?>

<div class="option-group-form">

    <div class="row">
        <div class="col-sm-6">
    <?php $form = ActiveForm::begin(); ?>
    <?php if (!empty($all_cats)) { ?>
        <div class="form-group">
            <label for="brand-category_id">Выберите категорию</label>
            <select name="OptionGroup[category_id]" class="form-control" id="brand-category_id" required="required">
                <?php if (!empty($all_cats)) { ?>
                    <?= $cats_formed ?>
                <?php } ?>
            </select>
        </div>
    <?php } else { ?>
        <?= $form->field($model, 'category_id')->dropDownList([]) ?>
    <?php } ?>
        </div>
        <?php if(!$model->isNewRecord) { ?>
            <div class="col-sm-6">
                <?php if (!empty($all_cats)) { ?>
                    <div class="form-group">
                        <label for="copy-category_id">Копировать в категорию</label>
                        <select name="Copy[category_id]" class="form-control" id="copy-category_id" required="required">
                            <?php if (!empty($all_cats)) { ?>
                                <?= $cats_formed ?>
                            <?php } ?>
                        </select>
                    </div>
                    <?= Html::submitButton('Копировать', ['class' => 'btn btn-primary']) ?>
                <?php } else { ?>
                    <?= $form->field($model, 'category_id')->dropDownList([]) ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>


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
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_uz">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_uz, 'name[uz]')->textInput(['value' => $info_uz->name]) ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_oz">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_oz, 'name[oz]')->textInput(['value' => $info_oz->name]) ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="perf_en">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($info_en, 'name[en]')->textInput(['value' => $info_en->name]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p></p>
    <div class="separator"></div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'type')->checkbox() ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'main')->checkbox() ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'range')->hiddenInput(['value'=>0])->label(false) ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'order')->textInput(['value' => ($model->order != '')? $model->order: 0]) ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Активен', '0' => 'Не активен']) ?>
        </div>
    </div>
    <div class="form-group">
        <a href="<?= Url::to(['option-group/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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