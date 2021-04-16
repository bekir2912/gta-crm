<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/*= $form->field($model, 'address')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model->address])->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
                'textOptions' => ['value' => $model->address, 'class' => 'form-control'],
                'attributeLatitude' => 'lat',
                'attributeLongitude' => 'lng',
                'googleMapApiKey' => 'AIzaSyB_x1j3WR5rH6hMDlm2_wfcVK7EI-30fx8',
                'draggable' => true,
                'wrapperOptions' => ['style' => 'width: 100%; height: 500px;'],
                'jsOptions' => ['lat' => 'width: 100%; height: 350px;'],
            ]); */

/* @var $this yii\web\View */
/* @var $model common\models\Social */
/* @var $form yii\widgets\ActiveForm */
$cities = \common\models\City::find()->all();

$all_cities = [];
for ($i = 0; $i < count($cities); $i++) {
    $all_cities[$cities[$i]->id] = $cities[$i]->translate->name;
}

?>

<div class="social-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'city_id')->dropDownList($all_cities) ?>
            <?= $form->field($model, 'type')->dropDownList(["Скорость", "Стоп линия"]) ?>
        </div>
        <div class="col-sm-8">
            <?= $form->field($model, 'address')->hiddenInput(['value' => $model->address? $model->address: '--'])->label(false) ?>

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
                            $('#radar-lat').val(placemarkPosition[0]);
                            $('#radar-lng').val(placemarkPosition[1]);
                        }
                    });


                    myMap.geoObjects.add(myPlacemark);
                }
            </script>
        </div>

    </div>

    <div class="form-group">
        <a href="<?= Url::to(['radar/index']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
