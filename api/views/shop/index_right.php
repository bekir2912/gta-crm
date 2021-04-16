<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 24.09.2017
 * Time: 3:35
 */
use yii\helpers\Url;
use yii\web\View;

$checked_filters = !empty(Yii::$app->request->get('filters')) ? Yii::$app->request->get('filters') : array();
$checked_shops = !empty(Yii::$app->request->get('shops')) ? Yii::$app->request->get('shops') : array();
$checked_brands = !empty(Yii::$app->request->get('brands')) ? Yii::$app->request->get('brands') : array();
$checked_lineups = !empty(Yii::$app->request->get('lineups')) ? Yii::$app->request->get('lineups') : array();
$all_params_opened = !empty(Yii::$app->request->get('all-params')) ? Yii::$app->request->get('all-params') : false;
$km_start = !empty(Yii::$app->request->get('kmstart')) ? Yii::$app->request->get('kmstart') : '';
$km_end = !empty(Yii::$app->request->get('kmend')) ? Yii::$app->request->get('kmend') : '';

$cities = \common\models\City::find()->where(['status' => 1])->orderBy('`order` ASC')->all();

$selected_city = (Yii::$app->request->get('city_id') > 0)? Yii::$app->request->get('city_id'): 0;
?>
<?php if (!empty($brands)
    || !empty($options)
    || $def_kmStart != 0
    || $def_kmEnd != 0
    || $def_pStart != 0 || $def_pEnd != 0) { ?>
    <section class="filter-block">
        <h3 class="middle__heading">
            <?=Yii::t('frontend', 'Filters')?>
        </h3>
        <form class="filter-form" action="<?= Url::to(['shop/index', 'id' => $shop->url, 'cat' => $category->url]) ?>" id="filter_form" data-pjax="true">
            <ul class="filter__list">
                <li class="filter__item">
                    <?php if (!empty($brands)) { ?>
                        <select class="filter__select filter_button" name="brands[]">
                            <option value="" disabled selected><?= Yii::t('frontend', 'Brand') ?></option>
                            <option value="" ></option>
                            <?php foreach ($brands as $brand_id => $brand) { ?>
                                <option value="<?= $brand->id ?>"
                                    <?= (in_array($brand->id, $checked_brands) ? 'selected' : '') ?>
                                ><?= $brand->name ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                    <?php if (!empty($lineups) && !empty(array_filter($checked_brands))) { ?>
                        <select class="filter__select filter_button" name="lineups[]">
                            <option value="" disabled selected><?= Yii::t('frontend', 'Lineup') ?></option>
                            <option value="" ></option>
                            <?php foreach ($lineups as $lineup_id => $lineup) { ?>
                                <option value="<?= $lineup->id ?>"
                                    <?= (in_array($lineup->id, $checked_lineups) ? 'selected' : '') ?>
                                ><?= $lineup->translate->name ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>

                    <?php if (!empty($options)) {
                        $show_all_params = false;
                        $chevron = 'down';
                        ?>
                        <?php foreach ($options['group'] as $group_id => $group) { ?>
                            <?php if ($group->category_id != $category->id) {
                                continue;
                            } ?>
                            <?php if (empty($options['values'][$group_id])) {
                                continue;
                            }
                            $main_class = 'opened';
                            if($group->main == 0) {
                                $main_class = 'not-main closed';
                                if ($all_params_opened == 'true') {
                                    $chevron = 'up';
                                    $main_class = 'not-main opened';
                                }
                                $show_all_params = true;
                            }
                            ?>
                            <?php if ($group->type == 1) { ?>
                                <div class="filter__select filter_multiOption <?= $main_class ?>">
                                    <div>
                                        <strong><?= $group->translate->name ?></strong>
                                    </div>
                                    <?php foreach ($options['values'][$group_id] as $value) { ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="filter_button" name="filters[]" value="<?= $group_id.'_'.$value->id ?>" <?= (in_array($group_id.'_'.$value->id, $checked_filters) ? 'checked' : '') ?>> <?=$value->translate->name?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <select class="filter__select filter_button <?= $main_class ?>" name="filters[]">
                                    <option value="" disabled selected><?= $group->translate->name ?></option>
                                    <option value="" ></option>
                                    <?php foreach ($options['values'][$group_id] as $value) { ?>
                                        <option value="<?= $group_id.'_'.$value->id ?>"
                                            <?= (in_array($group_id.'_'.$value->id, $checked_filters) ? 'selected' : '') ?>
                                        ><?=$value->translate->name?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                    <?php if($def_kmStart != 0 || $def_kmEnd != 0) { ?>
                        <div class="filter-price">
                            <input value="<?=$km_start?>" class="filter__select filter_button " type="number"  name="kmstart" placeholder="<?=Yii::t('frontend', 'mileage')?>, <?=mb_strtolower(Yii::t('frontend', 'From'))?>">
                            <input value="<?=$km_end?>" class="filter__select filter_button " type="number"  name="kmend" placeholder="<?=Yii::t('frontend', 'mileage')?>, <?=mb_strtolower(Yii::t('frontend', 'To'))?>">
                            <div class="filter__select" style="padding: 5px">
                                <label style="font-size: 14px;text-transform: unset;font-weight: normal;margin-bottom: 0;">
                                    <input type="checkbox" name="photo" value="1" class="filter_button" <?=($photo == 1)? 'checked': '' ?>> <?=Yii::t('frontend', 'With photo')?>
                                </label>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if($def_pStart != 0 || $def_pEnd != 0) { ?>
                        <div class="filter-price">
                            <p><strong><?=Yii::t('frontend', 'Price')?></strong></p>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12" style="padding: 0 45px;">
                                        <input id="price_range" class="irs-hidden-input" type="hidden" tabindex="-1" name="price_range" readonly="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                    <div class="filter-button-row">
                        <div class="filter-more-reset">
                            <?php if($show_all_params) { ?>
                                <a class="filter-all" id="filter-all" style="cursor: pointer;">
                                    <?=Yii::t('frontend', 'All Params')?> <span class="all-params-icon"><i class="fa fa-chevron-<?=$chevron?>"></i></span>
                                </a>
                                <input type="hidden" name="all-params" value="false" id="all-params">
                            <?php } ?>
                            <a class="filter-reset" href="<?= Url::to(['shop/list', 'id' => $category->url, 's' => Yii::$app->request->get('s'), 'sd' => Yii::$app->request->get('sd')]) ?>">
                                <?=Yii::t('frontend', 'Clear')?> <i class="fa fa-close"></i>
                            </a>
                        </div>
                        <a class="filter__button" type="submit" style="cursor: pointer;color: #ffff;">
                            <?=Yii::t('frontend', 'Show')?>
                            <span class="filter-result"><?=$pagination->totalCount?></span>
                            <?=Yii::t('frontend', 'variants')?>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                </li>
            </ul>
            <input type="hidden" name="s" value="<?=Yii::$app->request->get('s')?>">
            <input type="hidden" name="sd" value="<?=Yii::$app->request->get('sd')?>">
        </form>
        <div class="filter-result-block clearfix">
            <ul class="filter-result__list">
                <?php if(!empty($brands) && empty(array_filter($checked_brands))) {
                    $loop = 1;
                    ?>
                    <?php foreach ($brands as $brand_id => $brand) { ?>
                        <li class="filter-result__item">
                            <a href="<?=Url::current(['brands' => [$brand_id]])?>">
                                    <span class="filter-result__name">
                                        <?= $brand->name ?>
                                    </span>
                                <span class="filter-result__quantity">
                                        <?= (isset($brands_count[$brand_id])? $brands_count[$brand_id]: 0) ?>
                                    </span>
                            </a>
                        </li>
                        <?php
                        if ($loop == 12) break;
                        $loop++;
                    } ?>
                <?php } else if(!empty($lineups) && empty(array_filter($checked_lineups))) {
                    $loop = 1;
                    ?>
                    <?php foreach ($lineups as $lineup_id => $lineup) { ?>
                        <li class="filter-result__item">
                            <a href="<?=Url::current(['lineups' => [$lineup_id]])?>">
                                    <span class="filter-result__name">
                                        <?= $lineup->translate->name ?>
                                    </span>
                                <span class="filter-result__quantity">
                                        <?= (isset($lineups_count[$lineup_id])? $lineups_count[$lineup_id]: 0) ?>
                                    </span>
                            </a>
                        </li>
                        <?php
                        if ($loop == 12) break;
                        $loop++;
                    } ?>
                <?php } ?>
            </ul>
        </div>
    </section>
<?php } ?>
<?php $this->registerJs('
    $(function () {
        $(\'[data-toggle="tooltip"]\').tooltip();
        
    $(\'.filter_button, #city_id\').on(\'change\', function (e) {
        $(\'#filter_form\').submit();
    });
    $(\'#filter-all\').on(\'click\', function (e) {
        var chevron = \'fa fa-chevron-down\';
        $(\'.not-main\').each(function() {
            if($(this).hasClass(\'closed\')){
                chevron = \'fa fa-chevron-up\';
                $(this).addClass(\'opened\');
                $(this).removeClass(\'closed\');
                $(\'#all-params\').val(\'true\');
            } else {
                $(this).addClass(\'closed\');
                $(this).removeClass(\'opened\');
                $(\'#all-params\').val(\'false\');
            }
        });
        $(\'.all-params-icon i\').removeAttr(\'class\');
        $(\'.all-params-icon i\').addClass(\'fa\');
        $(\'.all-params-icon i\').addClass(chevron);
    });
    
    $(".filter__button").click(function() {
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#search-result").offset().top
    }, 500);
});

    })
'); ?>

<?php if($def_pStart != 0 || $def_pEnd != 0) { ?>
    <?php $this->registerCss('
        .closed {
            display: none;
        }
        .filter-all {
            color: #d91b30;
            margin-right: 10px;
        }
    ');?>
    <?php $this->registerCssFile('/js/ion.rangeSlider-2.2.0/css/ion.rangeSlider.css');?>
    <?php $this->registerCssFile('/js/ion.rangeSlider-2.2.0/css/ion.rangeSlider.skinFlat.css');?>
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