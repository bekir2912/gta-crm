<?php

use common\models\Shop;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */
/* @var $info common\models\ShopAddresses */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(Yii::$app->params['domain'].'/inputmask/jquery.inputmask.bundle.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile(Yii::$app->params['domain'].'/inputmask/inputmask/bindings/inputmask.binding.min.js', ['depends' => 'yii\web\JqueryAsset']);

function getTimeDropDown($active = '') {
    $times = [
        "00:00"=>"00:00",
        "00:30"=>"00:30",
        "01:00"=>"01:00",
        "01:30"=>"01:30",
        "02:00"=>"02:00",
        "02:30"=>"02:30",
        "03:00"=>"03:00",
        "03:30"=>"03:30",
        "04:00"=>"04:00",
        "04:30"=>"04:30",
        "05:00"=>"05:00",
        "05:30"=>"05:30",
        "06:00"=>"06:00",
        "06:30"=>"06:30",
        "07:00"=>"07:00",
        "07:30"=>"07:30",
        "08:00"=>"08:00",
        "08:30"=>"08:30",
        "09:00"=>"09:00",
        "09:30"=>"09:30",
        "10:00"=>"10:00",
        "10:30"=>"10:30",
        "11:00"=>"11:00",
        "11:30"=>"11:30",
        "12:00"=>"12:00",
        "12:30"=>"12:30",
        "13:00"=>"13:00",
        "13:30"=>"13:30",
        "14:00"=>"14:00",
        "14:30"=>"14:30",
        "15:00"=>"15:00",
        "15:30"=>"15:30",
        "16:00"=>"16:00",
        "16:30"=>"16:30",
        "17:00"=>"17:00",
        "17:30"=>"17:30",
        "18:00"=>"18:00",
        "18:30"=>"18:30",
        "19:00"=>"19:00",
        "19:30"=>"19:30",
        "20:00"=>"20:00",
        "20:30"=>"20:30",
        "21:00"=>"21:00",
        "21:30"=>"21:30",
        "22:00"=>"22:00",
        "22:30"=>"22:30",
        "23:00"=>"23:00",
        "23:30"=>"23:30",
    ];
    $result = '';
    foreach ($times as $time){
        $result .= '<option value="'.$time.'" '.(($active == $time)? 'selected="selected"': '').'>'.$time.'</option>';
    }
    return $result;
}

function getDaysMark($active) {
    $active = json_decode($active, 1);
    $days = [
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
        7 => 'Воскресенье',
    ];
    $result = '<div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-xs-4 text-center">
                </div>
                <div class="col-xs-3 text-center">
                    <strong>от</strong>
                </div>
                <div class="col-xs-3 text-center">
                    <strong>до</strong>
                </div>
                <div class="col-xs-2 text-center">
                    <strong>или 24ч</strong>
                </div>
            </div>';
    foreach ($days as $i => $day) {
        $checked_1 = '';
        $checked_2 = '';
        $selected_1 = '';
        $selected_2 = '';
        if(isset($active['days'][$i]) && $active['days'][$i] == 1) {
            $checked_1 = 'checked="checked"';
        }
        if(isset($active['alltime'][$i]) && $active['alltime'][$i] == 1) {
            $checked_2 = 'checked="checked"';
        }
        if(isset($active['time'][$i][1])) {
            $selected_1 = $active['time'][$i][1];
        }
        if(isset($active['time'][$i][2])) {
            $selected_2 = $active['time'][$i][2];
        }
        $result .= '<div class="row">
                <div class="col-xs-4">
                    <div class="checkbox">
                        <label>
                            <input type="hidden" name="Days['.$i.']" value="0"/>
                            <input type="checkbox" name="Days['.$i.']" value="1" '.$checked_1.'/> <strong>'.$day.'</strong>
                        </label>
                    </div>
                </div>
                <div class="col-xs-3 text-center">
                    <select name="Time['.$i.'][1]" class="form-control" >
                        '.getTimeDropDown($selected_1).'
                    </select>
                </div>
                <div class="col-xs-3 text-center">
                    <select name="Time['.$i.'][2]" class="form-control" >
                        '.getTimeDropDown($selected_2).'
                    </select>
                </div>
                <div class="col-xs-2 text-center">
                    <div class="checkbox">
                        <label>
                            <input type="hidden" name="AllTime['.$i.']" value="0"/>
                            <input type="checkbox" name="AllTime['.$i.']" value="1" '.$checked_2.'/>
                        </label>
                    </div>
                </div>
            </div>';
    }
    $result .= '
        </div>
    </div>';

    return $result;
}
$phones = explode('; ', $info->phone);
?>

<div class="shop-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-4 col-sm-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($info, 'email') ?>
            <div class="form-group">
                <label class="control-label" for="phone_1">Телефон 1</label>
                <input type="text" id="phone_1" class="form-control phones" name="phones[]" value="<?=(isset($phones[0]))? $phones[0]: ''?>" >
            </div>
            <div class="form-group">
                <label class="control-label" for="phone_1">Телефон 2</label>
                <input type="text" id="phone_1" class="form-control phones" name="phones[]" value="<?=(isset($phones[1]))? $phones[1]: ''?>" >
            </div>
            <div class="form-group">
                <label class="control-label" for="phone_1">Телефон 3</label>
                <input type="text" id="phone_1" class="form-control phones" name="phones[]" value="<?=(isset($phones[2]))? $phones[2]: ''?>" >
            </div>
        </div>
        <div class="col-md-4  col-sm-6">
            <?php if($model->logo != '') { ?>
                <img src="<?=$model->logo?>" alt="<?=$model->logo?>" class="img-responsive">
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
            ]); ?>
            <p style="font-size: 11px;color: #6b6b6b;margin-top: -10px;">
                <?=Yii::t('frontend', 'Shop logo size')?>
            </p>
            <?php if ($model->certificate != '') {
                ?>
                <img src="<?= $model->certificate ?>" alt="<?= $model->certificate ?>" class="img-responsive" style="max-width: 200px;">
            <?php } ?>
            <?= $form->field($model, 'certificate')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*', 'multiple' => false],
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' => 'Загрузить фото'
                ],
                'language' => 'ru'
            ]); ?>
        </div>

        <div class="col-md-4 col-sm-6">
            <?php if($model->image != '') { ?>
            <?php } ?>

            <?php if ($model->licence != '') {
                ?>
                <img src="<?= $model->licence ?>" alt="<?= $model->licence ?>" class="img-responsive" style="max-width: 200px;">
            <?php } ?>
            <?= $form->field($model, 'licence')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*', 'multiple' => false],
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' => 'Загрузить фото'
                ],
                'language' => 'ru'
            ]); ?>
        </div>
    </div>
    <div class="separator"></div>
    <h4>Дополнительно</h4>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#ru" aria-controls="ru" role="tab" data-toggle="tab">Русский</a></li>
                <li role="presentation"><a href="#uz" aria-controls="uz" role="tab" data-toggle="tab">Узбекский</a></li>
                <li role="presentation"><a href="#oz" aria-controls="oz" role="tab" data-toggle="tab">Oz'bekcha</a></li>
                <li role="presentation"><a href="#en" aria-controls="en" role="tab" data-toggle="tab">Английский</a></li>
            </ul>
            <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="ru">
                <p></p>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <?= $form->field($info, 'description[ru]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info->description]) ?>
                        <?= $form->field($info, 'schedule[ru]')->hiddenInput(['value' => ''])->label(false) ?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?= $form->field($info, 'address[ru]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info->address]) ?>


                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($info, 'lat')->hiddenInput(['value' => $info->lat? $info->lat: 41.4450174])->label(false) ?>
                        <?= $form->field($info, 'lng')->hiddenInput(['value' => $info->lng? $info->lng: 64.8666701])->label(false) ?>

                        <div id="map" style="width: 100%;height: 400px;"></div>
                        <script type="text/javascript">
                            // Функция ymaps.ready() будет вызвана, когда
                            // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
                            ymaps.ready(init);
                            function init(){

                                var myLatLng = [<?=$info->lat? $info->lat: 41.4450174?>, <?=$info->lng? $info->lng: 64.8666701?>];
                                var zoom = 6;

                                // Создание карты.
                                var myMap = new ymaps.Map("map", {
                                    // Координаты центра карты.
                                    // Порядок по умолчанию: «широта, долгота».
                                    // Чтобы не определять координаты центра карты вручную,
                                    // воспользуйтесь инструментом Определение координат.
                                    center: myLatLng,
                                    // Уровень масштабирования. Допустимые значения:
                                    // от 0 (весь мир) до 19.
                                    zoom: zoom
                                });


                                var myPlacemark = new ymaps.Placemark([<?=$info->lat? $info->lat: 41.4450174?>, <?=$info->lng? $info->lng: 64.8666701?>], {}, {
                                    draggable: true,
                                    preset: 'islands#redIcon',
                                });

                                myPlacemark.events.add([
                                    'dragend'
                                ], function (e) {
                                    var placemarkPosition = myMap.options.get('projection').fromGlobalPixels(
                                        myMap.converter.pageToGlobal(e.get('position')),
                                        myMap.getZoom()
                                    );

                                    if (placemarkPosition.length === 2) {
                                        $('#shopaddresses-lat').val(placemarkPosition[0]);
                                        $('#shopaddresses-lng').val(placemarkPosition[1]);
                                    }
                                });


                                myMap.geoObjects.add(myPlacemark);
                            }
                        </script>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="uz">
                <p></p>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <?= $form->field($info_uz, 'description[uz]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info_uz->description]) ?>
                        <?= $form->field($info_uz, 'schedule[uz]')->hiddenInput(['value' => ''])->label(false) ?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?= $form->field($info_uz, 'address[uz]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info_uz->address]); ?>
                    </div>
                </div>
            </div>
                <div role="tabpanel" class="tab-pane" id="oz">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <?= $form->field($info_oz, 'description[oz]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info_oz->description]) ?>
                            <?= $form->field($info_oz, 'schedule[oz]')->hiddenInput(['value' => ''])->label(false) ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <?= $form->field($info_oz, 'address[oz]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info_oz->address]); ?>
                        </div>
                    </div>
                </div>
            <div role="tabpanel" class="tab-pane" id="en">
                <p></p>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <?= $form->field($info_en, 'description[en]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info_en->description]) ?>
                        <?= $form->field($info_en, 'schedule[en]')->hiddenInput(['value' => ''])->label(false) ?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?= $form->field($info_en, 'address[en]')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $info_en->address]); ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <p><br></p>
    <div class="separator"></div>
    <h4>Режим работы</h4>
    <?=getDaysMark($info->schedule)?>
    <p><br></p>
    <div class="separator"></div>
    <h4>В каком городе предоставляются услуги</h4>
    <div class="row">
        <?php
        $selected_cities = (!$model->isNewRecord)? json_decode($model->cities): [];
        $selected_cities = ($selected_cities)? $selected_cities: [];
        $cities = \common\models\City::find()->where(['status' => 1])->all(); ?>
        <div class="col-sm-6">
            <div class="form-group">
                <select name="cities[]" class="form-control">
                    <?php if(!empty($cities)) { ?>
                    <?php foreach ($cities as $city) { ?>
                    <option value="<?=$city->id?>" <?=in_array($city->id, $selected_cities)? 'selected': ''?>> <?=$city->translate->name?>
                        <?php } ?>
                        <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="separator"></div>
    <h4>Юридическая информация</h4>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'legal_name')->textInput() ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'trademark')->textInput() ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'legal_phone')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'rs')->textInput() ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'bank')->textInput() ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'bank_city')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'mfo')->textInput() ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'inn')->textInput() ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'okonh')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'legal_address')->textarea() ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'physical_address')->textarea() ?>
        </div>
    </div>

    <p><br></p>
    <div class="separator"></div>
    <h4>Административные настройки</h4>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <p>
                <?= $form->field($model, 'seller_id')->textInput(['required' => 'required'])?>
                <?php if(!$model->isNewRecord) { ?>
                <br>
                <strong>Добавлено:</strong> <br>
                <span class="text-secondary"><?=date('d.m.Y', $model->created_at)?></span>
                <?php } ?>
            </p>
            <?= $form->field($model, 'order') ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'on_main')->checkbox() ?>
            <?= $form->field($model, 'top')->checkbox() ?>
            <?= $form->field($model, 'top_order') ?>
        </div>
        <div class="col-md-4 col-sm-6">
            <?= $form->field($model, 'service')->hiddenInput(['value' => 0])->label(false) ?>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Опубликован', '-1' => 'Заблокировать', '0' => 'На модерации']) ?>
        </div>
    </div>


    <div class="form-group text-center">
        <a href="<?=Url::to(['shop/index', 'sort' => '-id'])?>" class="btn btn-secondary btn-cancel">Все компании</a>

        <?php if(!$model->isNewRecord) { ?>
            <a href="<?=Url::to(['product/index', 'ProductSearch[shop_id]' => $model->id, 'sort' => '-id'])?>" class="btn btn-success btn-cancel">Объявления Компании</a>
        <?php } ?>

        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs('
    $(\'.phones\').inputmask({mask: "+\\\\9\\\\9\\\\8 (99) 999-99-99"});
')

?>