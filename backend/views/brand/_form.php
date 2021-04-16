<?php

use common\models\Category;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\widgets\ActiveForm */
$all_cats = Category::find()->where(['status' => 1])->limit(2)->all();

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

<div class="brand-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php if (!empty($all_cats)) { ?>
                <div class="form-group">
                    <label for="brand-category_id">Выберите категорию</label>
                    <select name="Brand[category_id]" class="form-control" id="brand-category_id" required="required">
                        <?php if (!empty($all_cats)) { ?>
                            <?= $cats_formed ?>
                        <?php } ?>
                    </select>
                </div>
            <?php } else { ?>
                <?= $form->field($model, 'category_id')->dropDownList([]) ?>
            <?php } ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php //$form->field($model, 'on_main')->checkbox() ?>
        </div>
        <!-- <?php if(!$model->isNewRecord) { ?>
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
        <?php } ?> -->
    </div>



    <p></p>
    <div class="separator"></div>
    <div class="row">

        
        <!-- <div class="col-sm-6 col-md-4">
            <p>
                <strong>Выберите лого</strong>
            </p>
                    <?php /*
                    if ($model->logo != '') {
                        ?>
                        <img src="<?= $model->logo ?>" alt="<?= $model->logo ?>" class="img-responsive">
                    <?php } ?>
                    <?= $form->field($model, 'logo')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*', 'multiple' => false],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' => 'Выбрать лого'
                        ],
                        'language' => 'ru'
                    ]); */?>
        </div> -->
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'order')->textInput(['value' => ($model->order != '')? $model->order: 0]) ?>
        </div>
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Активен', '0' => 'Не активен']) ?>
        </div>
    </div>
    <div class="form-group">
        <a href="<?= Url::to(['brand/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
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