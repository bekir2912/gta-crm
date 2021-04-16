<?php

use common\models\Brand;
use common\models\Category;
use common\models\Clients;
use common\models\OptionGroup;
use common\models\ProductPerformance;
use common\models\ProductPerformanceTranslation;
use common\models\Sale;
use common\models\Unit;
use kartik\file\FileInput;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */

$all_cats = Category::find()->where(['status' => 1, 'parent_id' => null])->limit(2)->all();
$all_brands = Brand::find()->where(['status' => 1, 'category_id' => $category->id])->all();
$options = OptionGroup::find()->where(['status' => 1, 'category_id' => $category->id, 'type' => 0])->orderBy('order')->all();
$options_multi = OptionGroup::find()->where(['status' => 1, 'category_id' => $category->id, 'type' => 1])->orderBy('order')->all();

$checked_options['id'] = [];
$checked_options['price'] = [];
if (!empty($model->activeOptions)) {
    foreach ($model->activeOptions as $checked_opt) {
        $checked_options['id'][$checked_opt->option_id] = $checked_opt->option_id;
        $checked_options['price'][$checked_opt->option_id] = $checked_opt->price;
    }
}
$brands = [];
if (!empty($all_brands)) {
    foreach ($all_brands as $brand) {
        $brands[$brand->id] = $brand->name;
    }
}

function recursiveOptions($all_cats, $index = 0)
{
    $result = '';
    $prefix = '';
    for ($i = 0; $i < $index; $i++) {
        $prefix .= '-';
    }
    foreach ($all_cats as $cats) {
        if (!empty($cats->activeCategories)) {
            $result .= '<optgroup label="' . $prefix . $cats->translate->name . '">';
            $result .= recursiveOptions($cats->activeCategories, $index + 1);
            $result .= '</optgroup>';
        } else {
            $result .= '<option value="' . $cats->id . '">' . $prefix . $cats->translate->name . '</option>';
        }
    }
    return $result;
}




$all_clients = Clients::find()->where(['status' => '1'])->all();


// debug($all_staff);
$clients = [];
if (!empty($all_clients)) {
    foreach ($all_clients as $client) {
        $clients[$client->id] = $client->FIO;
    }
}

$categoriess = [];
if (!empty($all_cats)) {
    foreach ($all_cats as $client) {
        $categoriess[$client->id] = $client->url;
    }
}
?>

<div class="product-form">
    <?php if (!$category) { ?>

        <form action="<?= Url::current() ?>" id="cat-form">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="category_id">Выберите категорию</label>
                    </div>

                    <?php if (!empty($all_cats)) { ?>
                        <ul class="list-unstyled category-widget-list">
                            <?php foreach ($all_cats as $all_cat) { ?>
                                <li data-id="<?=$all_cat->id?>" data-childs="<?=(!empty($all_cat->categories))?$all_cat->id:''?>" class="cat-widget-li"><?=$all_cat->translate->name?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <input type="text" name="category" id="category_id" value="" style="visibility: hidden;" />
                    <?php if (!empty($prod_id = Yii::$app->request->get('id'))) { ?>
                        <input type="hidden" name="id" value="<?= $prod_id ?>"/>
                    <?php } ?>
                </div>
            </div>
        </form>
    <?php } else { ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="category_id">Категория</label>
                    <input type="text" readonly="readonly" id="category_id" class="form-control"
                           value="<?= $category->translate->name ?>"/>
                    <a href="<?= Url::current(['category' => '']) ?>"
                       onclick="if(!confirm('Ожидается форма для сохранения. Отменить?'))return false;">Выбрать другую
                        категорию</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <?= $form->field($model, 'brand_id')->dropDownList($brands) ?>
            </div>
            <div class="col-sm-6 col-md-4">
                <?= $form->field($info, 'name[ru]')->textInput(['value' => $info->name]) ?>
            </div>
        </div>



        <div class="row">

            <div class="col-sm-6 col-md-6">
                <?= $form->field($model, 'client_id')->dropDownList($clients ) ?>
            </div>


            <div class="col-sm-6 col-md-6">
                <?= $form->field($model, 'status')->dropDownList(["1" => "Активен", "0" => "Не активен"]) ?>
            </div>


        </div>

        <div class="separator"></div>

        <div class="row">
            <div class="col-md-12">
                <!-- <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#ru" aria-controls="ru" role="tab"
                                                              data-toggle="tab"><?=Yii::t('frontend', 'ru')?></a></li>
                    <li role="presentation"><a href="#uz" aria-controls="uz" role="tab" data-toggle="tab"><?=Yii::t('frontend', 'uz')?></a>
                    </li>
                    <li role="presentation"><a href="#oz" aria-controls="oz" role="tab" data-toggle="tab"><?=Yii::t('frontend', 'oz')?></a>
                    </li>
                    <li role="presentation"><a href="#en" aria-controls="en" role="tab" data-toggle="tab"><?=Yii::t('frontend', 'en')?></a>
                    </li>
                </ul> -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="ru">
                        <p></p>
                        <div class="row">



                            <div class="col-sm-4">
                                <?= $form->field($model, 'auto_number')->textInput() ?>
                            </div>

                            <div class="col-sm-4">
                                <?= $form->field($model, 'mileage')->textInput() ?>
                            </div>

                            <div class="col-sm-4">
                                <?= $form->field($model, 'price')->textInput() ?>
                            </div>



                            <div class="col-sm-12">

                                <?= $form->field($info, 'description[ru]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info->description]) ?>
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-sm-6  col-md-8">
                            <label class="control-label"><?=Yii::t('frontend', 'Other Images')?></label>
                            <?php if (!empty($model->productImages)) { ?>
                                <div class="row">
                                    <?php foreach ($model->productImages as $images) {
                                        if ($images->main) continue;
                                        ?>
                                        <div class="col-sm-6 col-md-3">
                                            <img src="<?= $images->image ?>" alt="." class="img-responsive">
                                            <a href="#" class="delete_image text-danger" data-productid="<?= $images->product_id ?>"
                                               data-imageid="<?= $images->id ?>"><?= FA::i('remove') ?> <?=Yii::t('frontend', 'Delete image')?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <?php
                                echo FileInput::widget([
                                    'name' => 'images[]',
                                    'options' => ['accept' => "image/*", 'multiple' => true, 'enctype'=>'multipart/form-data' ],
                                    'pluginOptions' => [
                                        'uploadUrl' => '/uploads/',
                                        'showCaption' => true,
                                        'showRemove' => false,
                                        'showUpload' => false,
                                        'browseClass' => 'btn btn-primary btn-block',
                                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                        'browseLabel' => Yii::t('frontend', 'Choose few images'),
                                        'fileActionSettings' => [
                                            'showUpload' => false,
                                        ]
                                    ],
                                    'language' => 'ru'
                                ]);
                                ?>
                            </div>
                            <p style="font-size: 11px;color: #6b6b6b;margin-top: -10px;">
                                <?=Yii::t('frontend', 'Announce photo placeholder')?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?= $form->field($model, 'warranty')->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'year')->hiddenInput()->label(false); ?>
        </div>


        <?php if (!empty($options) || !empty($options_multi)) { ?>
            <div class="separator"></div>
            <h4><?=Yii::t('frontend', 'Options')?></h4>
            <?php if (!empty($options)) { ?>
                <div class="row options_label">
                    <?php $loop = 1;
                    foreach ($options as $group) { ?>
                        <div class="col-sm-4 ">
                            <div class="form-group">
                                <label for="control-label" class="options_<?=$loop?>"><?= $group->translate->name ?></label>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <select name="options[][id]" id="options_<?=$loop?>" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($group->activeOptions as $option) { ?>
                                                <option value="<?= $option->id ?>" <?php if (in_array($option->id, $checked_options['id'])) { ?>selected<?php } ?>><?= $option->translate->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="options[][price]" value="0">
                                </div>
                            </div>
                        </div>
                        <?php $loop++;
                    } ?>
                </div>
            <?php } ?>

            <?php if (!empty($options_multi)) { ?>
                <div class="row options_label">
                    <?php $loop = 1;
                    foreach ($options_multi as $group) { ?>

                        <div class="col-sm-12 ">
                            <div class="form-group">
                                <label class="multiOption_title"><?= $group->translate->name ?></label>

                                <div class="row">
                                    <?php foreach ($group->activeOptions as $option) { ?>
                                        <div class="col-sm-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="options[][id]" value="<?= $option->id ?> " <?php if (in_array($option->id, $checked_options['id'])) { ?> checked <?php } ?>><?= $option->translate->name ?>
                                                </label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="options[][price]" value="0">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <p></p>
                            <div class="separator"></div>
                        </div>
                        <?php $loop++;
                    } ?>

                </div>
            <?php } ?>

        <?php } ?>
    <div class="separator"></div>
    <div class="form-group">
        <a href="<?= Url::to(['lineup/index', 'sort' => '-id']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php } ?>


</div>

<?php $this->registerJs('
    $(document).on(\'ready pjax:success pjax:error\', function() {
        $(\'select.form-control\').select2(
            {
                language: {
                  noResults: function () {
                    return "Ничего не найдено";
                  }
                }
            }
        );
        $(document).on(\'click\', \'.cat-widget-li\', function () {
            id = $(this).data(\'id\');
            has_childs = $(this).data(\'childs\');
        
            li = $(this);
            if(has_childs != \'\') {
                $.ajax({
                    url: "/site/get-cats",
                    data: {\'id\': li.data(\'id\')}, //data: {}
                    type: "get",
                    success: function (t) {
                        $(\'.category-widget-list\').html(t);
                    }
                });
            }
            else {
                $(\'#category_id\').val(id);
                $(\'#cat-form\').submit();
            }
        });
        
        $(\'#add_cat_btn\').on(\'click\', function() {
            $($(\'#add-cat-temp\').html()).appendTo($(\'#added_cats\'));
            $(this).hide();
            return false;
        });
        $(document).on(\'click\', \'.add_cat_delete\', function () {
            $(this).parent().remove();
            return false;
        });
            var title = [];
        $(document).on(\'click\', \'.add-cat-widget-li\', function () {
            id = $(this).data(\'id\');
            has_childs = $(this).data(\'childs\');
            li = $(this);
            if(has_childs != \'\') {
                $.ajax({
                    url: "/lineup/get-cats",
                    data: {\'id\': li.data(\'id\'), \'add\': \'add-\'}, //data: {}
                    type: "get",
                    success: function (t) {
                        if(li.text() != \' Назад\') {
                            title.push(li.text() + \' > \');
                        }
                        else {
                            title.splice(title.length - 1, 1);
                        }
                        $(\'#added_cats .add-category-widget-list\').html(t);
                    }
                });
            }
            else {
                title.push(li.text() + \' > \');
                title = title.join(\'\');
                btn = \' <i class="fa fa-remove add_cat_delete btn btn-danger"></i>\';
                input = \' <input type="hidden" name="add_cats[]" value="\' + id + \'"/>\';
                input_title = \' <input type="hidden" name="add_cats_titles[\' + id + \']" value="\' + title.substr(0, title.length - 3) + \'"/>\';
                $(\'#adding_cats\').html($(\'#adding_cats\').html() + \'<p>\' + title.substr(0, title.length - 3) + btn + input + input_title + \'</p>\');
                title = [];
                $(\'#added_cats .add-category-widget-list\').remove();
                $(\'#add_cat_btn\').show();
            }
            return false;
        });
    });
');?>