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

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <?= $form->field($info, 'name[ru]')->textInput(['value' => $info->name])->label('Название (рус)') ?>
                    <?= $form->field($info_uz, 'name[uz]')->textInput(['value' => $info_uz->name])->label('Название (узб)') ?>
                    <?= $form->field($info_en, 'name[en]')->textInput(['value' => $info_en->name])->label('Название (анг)') ?>
                    <?= $form->field($info_oz, 'name[oz]')->textInput(['value' => $info_oz->name])->label('Название (O\'zb)') ?>
                </div>
            </div>
        <p></p>
        <div class="separator"></div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'address')->hiddenInput(['value' => $model->address? $model->address: '--']) ?>

                <?= $form->field($model, 'lat')->hiddenInput(['value' => $model->lat? $model->lat: 41.4450174])->label(false) ?>
                <?= $form->field($model, 'lng')->hiddenInput(['value' => $model->lng? $model->lng: 64.8666701])->label(false) ?>

                <div id="map" style="width: 100%;height: 400px;"></div>
                <script type="text/javascript">
                    // Функция ymaps.ready() будет вызвана, когда
                    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
                    ymaps.ready(init);
                    function init(){

                        var myLatLng = [<?=$model->lat? $model->lat: 41.4450174?>, <?=$model->lng? $model->lng: 64.8666701?>];
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


                        var myPlacemark = new ymaps.Placemark([<?=$model->lat? $model->lat: 41.4450174?>, <?=$model->lng? $model->lng: 64.8666701?>], {}, {
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
                                $('#city-lat').val(placemarkPosition[0]);
                                $('#city-lng').val(placemarkPosition[1]);
                            }
                        });


                        myMap.geoObjects.add(myPlacemark);
                    }
                </script>

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
            <a href="<?= Url::to(['city/index', 'sort' => 'order']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
