<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Shop;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use store\assets\AppAsset;
use common\widgets\Alert;

$selected_shop = Shop::findOne(['id' => Yii::$app->session->get('shop_id'), 'deleted_at' => 0]);
$shops = Shop::find()->where(['seller_id' => Yii::$app->user->id, 'deleted_at' => 0])->all();

$requestedRoute = explode('/', Yii::$app->requestedRoute);
$requestedRoute = $requestedRoute[0];

$new_chat = \common\models\Chat::find()->where(['shop_id' => Yii::$app->session->get('shop_id'), 'direction' => 1, 'is_read' => 0, 'type' => 'shop'])->count('id');

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="/uploads/site/favicon.png">

    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?=Yii::$app->params['ya_key']?>&lang=ru_RU" type="text/javascript">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar navbar-default z75 navbar-right">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="<?= Url::to(['site/index']) ?>">
                                <img alt="<?= Yii::$app->params['appName'] ?>" src="/uploads/site/logo.png" class="img=responsive">
                            </a>
<!--                            <a href="#" target="_blank" style="height: 25px; padding-top: 13px;display: inline-block;"><i class="fa fa-share fa-2x" data-toggle="tooltip" data-placement="bottom" title="Перейти на сайта" ></i></a>-->
                        </div>
                    </div>
                    <div class="pull-right">
                        <?php if(!Yii::$app->user->isGuest) { ?>
                        <ul class="list-unstyled shop_dropdown" style="display: inline-block">
                            <li class="dropdown">
                                <a href="<?=Url::to(['balance/fill'])?>" class="dropdown-toggle dib">
                                   <span class="text-secondary">
                                        <?=number_format(Yii::$app->getUser()->identity->balance, 0, '', ' ')?> <?=Yii::t('frontend', 'uzs')?>
                                   </span>
                                </a>
                            </li>
                        </ul>
                        <?php } ?>
                        <?php if(!Yii::$app->user->isGuest && $shops) { ?>
                            <ul class="list-unstyled shop_dropdown" style="display: inline-block">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle dib" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-secondary"><?=FA::i('shopping-bag')?> <span
                                                class="hidden-xs">Компании</span> <?= FA::i('angle-down') ?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <?php foreach ($shops as $shop) { ?>
                                            <li><a href="<?=Url::to(['site/change-shop', 'id' => $shop->id])?>" <?=($shop->id == $selected_shop->id)? ' style="color: #fa7c0d"':''?>><?=$shop->name?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        <?php } ?>

                        <?php if (Yii::$app->user->isGuest) { ?>
                            <?php if (Yii::$app->requestedAction->id == 'login') { ?>
                                <a class="btn btn-top" href="<?= Url::to(['site/signup']) ?>">
                                    <?= FA::i('user-plus') ?> <span
                                            class="hidden-xs">Подать заявку</span>
                                </a>
                            <?php } else { ?>
                                <a class="btn btn-top" href="<?= Url::to(['site/login']) ?>">
                                    <?= FA::i('user-circle-o') ?> <span
                                            class="hidden-xs">Вход</span>
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="dropdown" style="display: inline-block">
                                <button class="btn btn-top dropdown-toggle" type="button" id="dropdownMenu2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <?= FA::i('user-circle-o') ?> <span
                                            class="hidden-xs">Личный кабинет</span> <?= FA::i('angle-down') ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <li>
                                        <a href="<?= Url::to(['seller/update']) ?>"><?=FA::i('user')->addCssClass('text-secondary')?> Профиль</a>
                                    </li>
                                    <li>
                                        <?= Html::beginForm(['/site/logout'], 'post') .
                                        Html::submitButton(
                                            FA::icon('sign-out')->addCssClass('text-danger') . ' ' . ' Выйти',
                                            ['class' => 'btn-link logout-btn logout text-left']
                                        )
                                        . Html::endForm()
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <?php if(Yii::$app->user->isGuest) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="right-content">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <?= Alert::widget() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
                    <div class="row">
                        <div class="col-sm-3 col-lg-2">
                            <nav class="navbar navbar-default navbar-fixed-side">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <span class="navbar-brand left_menu_shop_name"><?=($selected_shop)? mb_substr($selected_shop->name, 0, 10): ''?></span>
                                    </div>

                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="nav navbar-nav" style="padding-bottom: 50px;">
                                            <?php if(!empty($selected_shop)) { ?>
                                                <li <?=($requestedRoute == 'site' || $requestedRoute == '')? 'class="active"': '';?>><a href="<?=Url::to(['site/index'])?>"><?=FA::i('home')?> Главная</a></li>
                                                <li <?=(Yii::$app->requestedRoute == 'shop/update')? 'class="active"': '';?>><a href="<?=Url::to(['shop/update'])?>"><?=FA::i('info')?> Информация компании</a></li>
                                                <li <?=($requestedRoute == 'product')? 'class="active"': '';?>><a href="<?=Url::to(['product/index', 'sort' => '-id'])?>"><?=FA::i('car')?> Объявления</a></li>
                                                <li <?=($requestedRoute == 'messages')? 'class="active"': '';?>><a href="<?=Url::to(['messages/index'])?>" ><?=FA::i('wechat')?> Сообщения   <?=($new_chat > 0)? '<span class="badge">'.$new_chat.'</span>':''?></a></li>
                                                <li <?=($requestedRoute == 'review')? 'class="active"': '';?>><a href="<?=Url::to(['review/index'])?>" ><?=FA::i('comment')?> Отзывы</a></li>
                                            <?php } ?>
                                            <li <?=($requestedRoute == 'shop' && Yii::$app->requestedRoute != 'shop/update')? 'class="active"': '';?>><a href="<?=Url::to(['shop/index'])?>"><?=FA::i('shopping-bag')?> Компании</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <div class="col-sm-9 col-lg-10">
                            <div class="right-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= Alert::widget() ?>
                                        <?= Breadcrumbs::widget([
                                            'links' => isset($this->params['breadcrumbs']) ? ($this->params['breadcrumbs']) : [],
                                            'homeLink' => false
                                        ]) ?>
                                    </div>
                                </div>
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
        <?php } ?>
    </div>
</div>
<?php if (Yii::$app->user->isGuest) { ?>
<footer class="footer border-top copyright">
    <div class="container ">
        <div class="row">
            <div class="col-sm-4">
                <p>
                    &copy; <?= Yii::$app->params['appName'] ?> <span class="hidden-xs"><?= ((date('Y') > 2017) ? '2017-' : '') . date('Y') ?></span>
                </p>
                <p>
                    <?= Yii::t('common', 'powered') ?>
                </p>
            </div>
            <div class="col-sm-4">
                <p><strong>Служба поддержки:</strong></p>
                <p><?= Yii::$app->params['client_support_service'] ?></p>
            </div>
            <div class="col-sm-4">
                <p><strong>Email:</strong></p>
                <p><?= Yii::$app->params['salesEmail'] ?></p>
            </div>
        </div>
    </div>
</footer>
<?php } else { ?>
    <footer class="footer border-top ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <p class="pull-right">
                        &copy; <?= Yii::$app->params['appName'] ?> <span class="hidden-xs"><?= ((date('Y') > 2017) ? '2017-' : '') . date('Y') ?></span>
                    </p>
                </div>
            </div>
        </div>
    </footer>
<?php } ?>

<?php $this->registerJs('
    $(function () {
        $(\'[data-toggle="tooltip"]\').tooltip();
    });
'); ?>

<?php
if(!Yii::$app->user->isGuest){
    $user_isAuth = Yii::$app->session->get('user_isAuth', 'true');
    if($user_isAuth == 'true') {
        $this->registerJs('
        $(document).on(\'ready pjax:success pjax:error\', function() {
            setTimeout(function() {
                $.ajax({
                    url: "https://seller.uz/ru/site/auth-back",
                    data: {\'username\': \''.(base64_encode('seller2018secret'.Yii::$app->user->identity->username)).'\'}, //data: {}
                    type: "post",
                     xhrFields: { withCredentials: true },
                     crossDomain: true,
                });
            }, 2000);
        });
    ', \yii\web\View::POS_END);
        Yii::$app->session->set('user_isAuth', 'false');
    }
}
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>