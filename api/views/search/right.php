<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 24.09.2017
 * Time: 3:35
 */
use yii\helpers\Url;

$checked_filters = !empty(Yii::$app->request->get('filters')) ? Yii::$app->request->get('filters') : array();
$checked_shops = !empty(Yii::$app->request->get('shops')) ? Yii::$app->request->get('shops') : array();
$checked_brands = !empty(Yii::$app->request->get('brands')) ? Yii::$app->request->get('brands') : array();

$cities = \common\models\City::find()->where(['status' => 1])->orderBy('`order` ASC')->all();

$selected_city = (Yii::$app->request->get('city_id') > 0)? Yii::$app->request->get('city_id'): 0;
?>
<?php if (!empty($products) || !empty($checked_shops) || !empty($checked_filters) || !empty($checked_brands) || $selected_city > 0 || !empty(Yii::$app->request->get('price_range'))) { ?>
<div class="row">
    <div class="col-md-12 ">
        <div class="filters">
        <h4 class="text-center"><?=Yii::t('frontend', 'Filters')?></h4>
        <form action="<?= Url::to(['search/index', 'q' => Yii::$app->request->get('q')]) ?>" id="filter_form" data-pjax="true">
            <div class="filter-block">
                <p><strong><?=Yii::t('frontend', 'City')?></strong></p>
                <div class="form-group">
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="0"><?=Yii::t('frontend', 'All cities')?></option>
                        <?php if(!empty($cities)) { ?>
                            <?php foreach($cities as $city) { ?>
                                <option value="<?=$city->id?>" <?=($selected_city == $city->id)?' selected="selected"': ''?>><?=$city->translate->name?></option>
                            <?php }}?>
                    </select>
                </div>
            </div>
            <?php if($def_pStart != 0 && $def_pEnd != 0) { ?>
                <div class="filter-block">
                    <p><strong><?=Yii::t('frontend', 'Price')?></strong></p>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <input id="price_range" class="irs-hidden-input" type="hidden" tabindex="-1" name="price_range" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($brands)) { ?>
                <div class="filter-block">
                    <p><strong><?=Yii::t('frontend', 'Brands')?></strong></p>
                    <?php foreach ($brands as $name => $brand_ids) { ?>
                        <div class="checkbox <?= (in_array(implode(',', $brand_ids), $checked_brands) ? 'active-prod-filter"' : '') ?>">
                            <label>
                                <input type="checkbox" class="filter_button" name="brands[]" value="<?= implode(',', $brand_ids) ?>"
                                    <?= (in_array(implode(',', $brand_ids), $checked_brands) ? 'checked="checked"' : '') ?>
                                > <?= $name ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if (!empty($shops)) { ?>
                <div class="filter-block">
                    <p><strong><?=Yii::t('frontend', 'Shops')?></strong></p>
                    <?php foreach ($shops as $shop_id => $shop) { ?>
                        <div class="checkbox <?= (in_array($shop->id, $checked_shops) ? 'active-prod-filter"' : '') ?>">
                            <label>
                                <input type="checkbox" class="filter_button" name="shops[]" value="<?= $shop->id ?>"
                                    <?= (in_array($shop->id, $checked_shops) ? 'checked="checked"' : '') ?>
                                > <?= $shop->name ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!empty($options)) { ?>
                <?php foreach ($options['group'] as $group_id => $group) { ?>
                    <?php if ($group->category_id != $cat) {
                        continue;
                    } ?>
                    <?php if (empty($options['values'][$group_id])) {
                        continue;
                    } ?>
                    <div class="filter-block">
                        <p><strong><?= $group->translate->name ?></strong></p>
                        <?php foreach ($options['values'][$group_id] as $value) { ?>
                            <div class="checkbox <?= (in_array($group_id.'_'.$value->id, $checked_filters) ? 'active-prod-filter"' : '') ?>">
                                <label>
                                    <input type="checkbox" class="filter_button" name="filters[]" value="<?= $group_id.'_'.$value->id ?>"
                                        <?= (in_array($group_id.'_'.$value->id, $checked_filters) ? 'checked="checked"' : '') ?>
                                    > <?= ($value->image != '')? '<img src="'.$value->image.'" alt="'.$value->translate->name.'" data-toggle="tooltip" data-placement="top" title="'.$value->translate->name.'"/>': $value->translate->name ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <input type="hidden" name="s" value="<?=Yii::$app->request->get('s')?>">
            <input type="hidden" name="sd" value="<?=Yii::$app->request->get('sd')?>">
            <div class="text-center">
                <a href="<?=Url::to(['search/index', 'q' => Yii::$app->request->get('q'), 's' => Yii::$app->request->get('s'),'sd' =>Yii::$app->request->get('sd')])?>" class="text-danger"><?=Yii::t('frontend', 'Clear')?></a>
                <br>
                <button type="submit" class="btn btn-primary"><?=Yii::t('frontend', 'Show')?></button>
            </div>
        </form>
    </div>
    </div>
</div>
<?php } ?>


<?php $this->registerJs('
    $(function () {
        $(\'[data-toggle="tooltip"]\').tooltip();
    })
'); ?>

<?php if($def_pStart != 0 && $def_pEnd != 0) { ?>
    <?php $this->registerJsFile('/js/ion.rangeSlider-2.2.0/js/ion-rangeSlider/ion.rangeSlider.min.js', ['depends' => ['yii\web\YiiAsset']]);?>
    <?php $this->registerJs('
        $(function () {
            $("#price_range").ionRangeSlider({
                type: "double",
                grid: true,
                step: 1000,
                min: '.$def_pStart.',
                max: '.$def_pEnd.',
                from: '.(Yii::$app->request->get('price_range')? $pStart: $def_pStart).',
                to: '.(Yii::$app->request->get('price_range')? $pEnd: $def_pEnd).',
                onFinish: function (data) {
                    $(\'#filter_form\').submit();
                }
    //            ,prefix: "$"
            });
        })
    '); ?>
<?php } ?>