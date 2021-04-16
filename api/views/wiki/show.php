<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 26.09.2017
 * Time: 8:01
 */

use common\models\Callback;
use common\models\Lineup;
use common\models\User;
use frontend\widgets\WProduct;
use newerton\fancybox3\FancyBox;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = $lineup->translate->name;

$this->registerMetaTag([
    'name' => 'description',
    'content' => Html::encode(strip_tags($lineup->translate->description)),
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Html::encode(strip_tags($lineup->translate->description)),
]);

$breads[] = [
        'name' => Yii::t('frontend', 'Wiki'),
        'url' => Url::to(['wiki/list'])
];
$breads[] = [
        'name' => $lineup->brand->name,
        'url' => Url::to(['wiki/index', 'id' => $lineup->brand->id])
];
$breads[] = [
        'name' => $lineup->translate->name,
        'url' => ''
];
?>

    <div class="bread-crumbs">
        <ul class="bread-crumbs__list">
            <?php for($i = 0; $i < count($breads); $i++) { ?>
                <li class="bread-crumbs__item">
                    <?php if ($i + 1 != count($breads)) { ?>
                    <a href="<?=$breads[$i]['url']?>" class="bread-crumbs__link">
                        <?php } ?>
                        <?=$breads[$i]['name']?>
                        <?php if ($i + 1 != count($breads)) { ?>
                    </a>
                <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
            <section class="car-description">
                <h2 class="car-description__heading">
                    <?= $lineup->translate->name ?>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <?php if($lineup->logo != '/uploads/site/default_cat.png') { ?>
                            <img src="<?=$lineup->logo?>" alt="" style="margin-top: 20px;">
                        <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <div class="car-description__tabs">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#comment" data-toggle="tab"><?=Yii::t('frontend', 'Description')?></a></li>
                                <li><a href="#equipment" data-toggle="tab"><?=Yii::t('frontend', 'Product Options')?></a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="comment">
                                    <?=($lineup->translate->description != '')? nl2br($lineup->translate->description): '<div class="text-center">'.Yii::t('frontend', 'No info').'</div>' ?>
                                </div>
                                <div class="tab-pane" id="equipment">
                                    <?php if (!empty($lineup->activeOptions)) { ?>
                                        <div class="characteristics">
                                            <ul class="characteristics__list" id="char_list_equipment">
                                                <?php
                                                $temp = '';
                                                foreach ($lineup->activeOptions as $option) {
                                                    if($option->option->group->translate->name == $temp) {
                                                        continue;
                                                    }
                                                    ?>
                                                    <li class="characteristics__item">
                                                        <?=$option->option->group->translate->name ?>
                                                    </li>
                                                    <?php $temp = $option->option->group->translate->name;} ?>
                                            </ul>
                                            <ul class="characteristics__list characteristics__list--bold" id="char_list_equipment_equals">
                                                <li class="characteristics__item" style="margin: 0">
                                                    <?php
                                                    $temp = '';
                                                    foreach ($lineup->activeOptions as $option) {
                                                    if($option->option->group->translate->name == $temp) {
                                                        ?>
                                                        , <?= $option->option->translate->name ?>
                                                        <?php
                                                    } else { ?>
                                                </li>
                                                <li class="characteristics__item">
                                                    <?= $option->option->translate->name ?>
                                                    <?php } ?>
                                                    <?php $temp = $option->option->group->translate->name;} ?>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center"><?=Yii::t('frontend', 'No info')?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<?php

$this->registerJs(
        "
            $(document).on('ready pjax:success pjax:error', function() {
                $('a[data-toggle=\"tab\"]').on('shown.bs.tab', function (e) {
                  e.target // newly activated tab
                  e.relatedTarget // previous active tab
                  if($(e.target).attr('href') == '#equipment') {
                      $('#char_list_equipment > li').each(function(i, v) {
                        if($(this).height() < $($('#char_list_equipment_equals > li')[i + 1]).height()) {
                            $(this).height($($('#char_list_equipment_equals > li')[i + 1]).height());
                        } else {
                            $($('#char_list_equipment_equals > li')[i + 1]).height($(this).height());
                        }
                      });
                  }
                  
                  if($(e.target).attr('href') == '#reference') {
                      $('#char_list_reference > li').each(function(i, v) {
                        if($(this).height() < $($('#char_list_reference_equals > li')[i + 1]).height()) {
                            $(this).height($($('#char_list_reference_equals > li')[i + 1]).height());
                        } else {
                            $($('#char_list_reference_equals > li')[i + 1]).height($(this).height());
                        }
                      });
                  }
                })
                
                  $('#char_list_main > li').each(function(i, v) {
                    if($(this).height() < $($('#char_list_main_equals > li')[i]).height()) {
                        $(this).height($($('#char_list_main_equals > li')[i]).height());
                    } else {
                        $($('#char_list_main_equals > li')[i]).height($(this).height());
                    }
                  });
                
            });
        "
);
