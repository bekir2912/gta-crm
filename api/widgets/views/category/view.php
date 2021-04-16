<?php

use yii\helpers\Url;

$root_cat = Yii::$app->session->get('root_category');
$page = Yii::$app->session->get('page');
$found_variants = Yii::$app->session->get('found_variants', 0);

$new_mes = 0;
if (!Yii::$app->user->isGuest) {
    $new_mes_user = \common\models\Chat::find()->where(['shop_id' => Yii::$app->getUser()->identity->id, 'type' => 'user', 'is_read' => 0])->count();
    $new_mes_shop = \common\models\Chat::find()->where(['user_id' => Yii::$app->getUser()->identity->id, 'type' => 'shop', 'type' => 'shop', 'direction' => '2', 'is_read' => 0])->count();
    $new_mes = $new_mes_user + $new_mes_shop;
    if($new_mes > 9) {
        $new_mes = '9+';
    }
}
?>

<ul class="navigation__list" >
    <?php for ($i = 0; $i < count($menu); $i++) { ?>
        <li class="navigation__item <?= ($root_cat == $menu[$i]->id) ? 'open' : '' ?>">
            <a class="navigation__link dropdown-toggle"
               href="<?= ($menu[$i]->on_main == 1)? Url::to(['service/list', 'id' => $menu[$i]->url]) :Url::to(['category/index', 'id' => $menu[$i]->url]) ?>">
                <?= $menu[$i]->translate->name ?>
            </a>
            <ul class="navigation__dropdown dropdown-menu hidden-1200">
                <?php if($menu[$i]->on_main == 0) { ?>
                <li class="navigation__dropdown-item ">
                    <a class="navigation__dropdown-link <?=($page == 'category')? ' active':''?>" href="<?=Url::to(['category/index', 'id' => $menu[$i]->url])?>"><?= Yii::t('frontend', 'All Announces') ?></a>
                </li>
                <?php if($menu[$i]->spec == 0) { ?>
                    <li class="navigation__dropdown-item ">
                        <a class="navigation__dropdown-link <?=($page == 'category-sell')? ' active':''?>" href="<?=Url::to(['category/index', 'id' => $menu[$i]->url, 'type' => 'sell'])?>"><?= Yii::t('frontend', 'Sell') ?></a>
                    </li>
                    <li class="navigation__dropdown-item ">
                        <a class="navigation__dropdown-link <?=($page == 'category-buy')? ' active':''?>" href="<?=Url::to(['category/index', 'id' => $menu[$i]->url, 'type' => 'buy'])?>"><?= Yii::t('frontend', 'Buy') ?></a>
                    </li>
                    <li class="navigation__dropdown-item ">
                        <a class="navigation__dropdown-link <?=($page == 'category-arenda')? ' active':''?>" href="<?=Url::to(['category/index', 'id' => $menu[$i]->url, 'type' => 'arenda'])?>"><?= Yii::t('frontend', 'Arenda') ?></a>
                    </li>
                <?php } ?>
                <li class="navigation__dropdown-item">
                    <a class="navigation__dropdown-link <?=($page == 'shops')? ' active':''?>" href="<?= Url::to(['shop/list', 'id' => $menu[$i]->url]) ?>"><?= Yii::t('frontend', 'Shops') ?></a>
                </li>
                <?php } elseif($page == 'services') { ?>
                    <li class="navigation__dropdown-item ">
                        <a class="navigation__dropdown-link navigation__dropdown-no-hover" ><?=Yii::t('frontend', 'Found variants')?>: <?=$found_variants?></a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <li class="navigation__item navigation__item_small">
        &nbsp;
    </li>
    <li class="navigation__item navigation__item_small">
        &nbsp;
    </li>
    <li class="navigation__item navigation__item_small <?= (!$root_cat && ($page == 'forum-list' || $page == 'forum-item' || $page == 'add-question')) ? 'open' : '' ?>">
        <a class="navigation__link dropdown-toggle" style="margin-right: 15px;"
                href="<?=Url::to(['forum/index'])?>">
            <?= Yii::t('frontend', 'Forum') ?>
        </a>
        <?php if($page == 'forum-list') { ?>
            <ul class="navigation__dropdown dropdown-menu">
                <li class="navigation__dropdown-item ">
                    <a class="navigation__dropdown-link navigation__dropdown-no-hover" ><?=Yii::t('frontend', 'Forum all themes')?>: <?=$found_variants?></a>
                </li>
            </ul>
        <?php } ?>
        <?php if($page == 'forum-item') { ?>
            <ul class="navigation__dropdown dropdown-menu">
                <li class="navigation__dropdown-item " style="margin-right: 0;">
                    <a class="navigation__dropdown-link " href="<?=Url::to(['forum/index'])?>"><?=Yii::t('frontend', 'Forum all themes')?> </a>
                </li>
                <li class="navigation__dropdown-item ">
                    <a class="navigation__dropdown-link navigation__dropdown-no-hover ellipsis" >
                        <i class="fa fa-chevron-right" style="font-size: 11px;"></i> <?=$found_variants?>
                    </a>
                </li>
            </ul>
        <?php } ?>
    </li>
    <li class="navigation__item navigation__item_red">
        <a href="<?= Url::to(['announcement/create']) ?>" class="navigation__link">
            <span class="flaticon-plus"></span>
            <?= Yii::t('frontend', 'Add') ?>
        </a>
    </li>
    <li class="navigation__item navigation__locale">
        <div class="dropdown">
            <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <span class="locale__text locale__text-current"><?=$current->name?></span>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <ul class="locale-list">
                    <?php foreach ($langs as $lang) { ?>
                        <li class="locale__item">
                            <a href="<?= '/' . $lang->url . Yii::$app->getRequest()->getLanguageUrl() ?>"
                               class="locale__link locale__text">
                                <?=$lang->name?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </li>
    <li class="navigation__item navigation__button  <?= ($page == 'cabinet') ? 'open' : '' ?>">
        <?php if (Yii::$app->user->isGuest) { ?>
        <a href="<?= Url::to(['announcement/index']) ?>"  style="padding: 5px 0 0;display: block;color: #fff;font-family: 'Gothampro Med', Arial, sans-serif;
            font-size: 16px;" class="hovered_link">
            <?= Yii::t('frontend', 'Sign In') ?>
        </a>
        <a href="<?= Url::to(['site/signup']) ?>"  style="padding: 0;display: block;color: #d91b30;font-family: 'Gothampro Med', Arial, sans-serif;
            font-size: 14px;" class="hovered_link">
            <?= Yii::t('frontend', 'Sign Up') ?>
        </a>
        <?php } else { ?>
            <a href="<?= Url::to(['announcement/index']) ?>" class="navigation__link">
                <?= Yii::t('frontend', 'Cabinet')  ?>
            </a>
        <?php } ?>
        <?php if (!Yii::$app->user->isGuest) { ?>
            <ul class="navigation__dropdown dropdown-menu">
                <li class="navigation__dropdown-item">
                    <a class="navigation__dropdown-link <?= ($root_cat == 'cabinet/announce') ? ' active ' : '' ?>"
                       href="<?= Url::to(['announcement/index']) ?>">
                        <?= Yii::t('frontend', 'Announce') ?>
                    </a>
                </li>
                <li class="navigation__dropdown-item">
                    <a class="navigation__dropdown-link  <?= ($root_cat == 'cabinet/messages') ? ' active ' : '' ?>"
                       href="<?= Url::to(['user/messages']) ?>">
                        <?= Yii::t('frontend', 'Messages') ?> <?=($new_mes > 0)? '<span class="badge">'.$new_mes.'</span>': ''?>
                    </a>
                </li>
                <li class="navigation__dropdown-item">
                    <a class="navigation__dropdown-link <?= ($root_cat == 'cabinet/index') ? ' active ' : '' ?>"
                       href="<?= Url::to(['user/index']) ?>">
                        <?= Yii::t('frontend', 'Settings') ?>
                    </a>
                </li>
                <li class="navigation__dropdown-item">
                    <a class="navigation__dropdown-link" href="<?= Url::to(['site/logout']) ?>">
                        <?= Yii::t('frontend', 'Logout') ?>
                    </a>
                </li>
            </ul>
        <?php } ?>
    </li>
</ul>
