<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($shops)) {?>
    <div class="bg-white">
        <div class="container">
            <div class=" shop-page-header" style="padding: 0 0 12px 0;font-weight: normal;font-family: magistral-regular, gotham-pro, Helvetica,Arial sans-serif;">
                <?=Yii::t('frontend', 'Shops')?>
                    <small class="pull-right"><a href="<?=Url::to(['shop/list'])?>"><?=Yii::t('frontend', 'Show all')?></a></small>
                <div class="clearfix"></div>
            </div>
            <div class="shop-block">
                <?php for ($i = 0; $i < count($shops); $i++) { ?>
                    <a href="<?=Url::to(['shop/index', 'id' => $shops[$i]->url])?>" data-pjax="0">
                        <img src="<?=$shops[$i]->logo;?>" alt="<?=$shops[$i]->name;?>" >
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>