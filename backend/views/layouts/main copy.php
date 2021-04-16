<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Admin;


$requestedRoute = explode('/', Yii::$app->requestedRoute);
$requestedRoute = $requestedRoute[0];

$product_count = \common\models\Product::find()->where(['is_moderated' => 0])->count('id');
$reviews = \common\models\ShopReview::find()->where(['is_moderated' => 0])->count('id');
$questions = \common\models\Question::find()->where(['is_moderated' => 0])->count('id');
$answers = \common\models\Answer::find()->where(['is_moderated' => 0])->count('id');


$admin = Admin::find()->one();



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
    <title><?= Html::encode($this->title) ?></title>


    <!-- <script src="https://api-maps.yandex.ru/2.1/?apikey=<?=Yii::$app->params['ya_key']?>&lang=ru_RU" type="text/javascript"> -->
    </script>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script>
    <?php $this->head() ?>
</head>
<body>
<div class="wrap">
    <nav class="navbar navbar-default  navbar-right">
        <div class="container-fluid">
            <div class="row custom-navbar">
                <div class="col-md-12">
                    <div class="pull-left">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="<?= Url::to(['site/index']) ?>">
                                <!-- <img alt="<?= Yii::$app->params['appName'] ?>" src="/uploads/site/logo.png" class="img=responsive"> -->
                                ГТА-CRM system
                            </a>
<!--                            <a href="#" target="_blank" style="height: 25px; padding-top: 13px;display: inline-block;"><i class="fa fa-share fa-2x" data-toggle="tooltip" data-placement="bottom" title="Перейти на сайта" ></i></a>-->
                        </div>
                    </div>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                    <div class="pull-right">
                        <ul class="list-unstyled shop_dropdown">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle dib" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-secondary"><span
                                                class="hidden-xs" style="color: white">Личный кабинет</span> </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="<?= Url::to(['admin/update', 'id' => Yii::$app->user->id]) ?>"><?=FA::i('user')->addCssClass('text-secondary')?> Профиль</a>
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
                            </li>
                        </ul>
                    </div>
                    <?php } ?>
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
                                 <?php if( Yii::$app->session->hasFlash('success') ): ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <?php echo Yii::$app->session->getFlash('success'); ?>
                                    </div>
                                <?php endif;?>
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
                                <span class="navbar-brand left_menu_shop_name"><span class = "admin">  Admin:  <?=$admin->name?></span>  </span>
                            </div>

                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav" style="padding-bottom: 50px;">
                                    <li <?=($requestedRoute == 'site' || $requestedRoute == '')? 'class="active"': '';?>><a href="<?=Url::to(['site/index'])?>"><?=FA::i('home')?> Главная</a></li>
                                    <!-- <li <//?=($requestedRoute == 'shop' || $requestedRoute == 'product' || $requestedRoute == 'sale'|| $requestedRoute == 'shop-delivery')? 'class="active"': '';?>><a href="<?=Url::to(['shop/index', 'sort' => '-id'])?>"><?=FA::i('shopping-bag')?> Компании</a></li> -->
                                    <li <?=($requestedRoute == 'lineup')? 'class="active"': '';?>><a href="<?=Url::to(['lineup/index', 'sort' => '-id'])?>"><?=FA::i('car')?> Машины</a></li>
                                    <li <?=($requestedRoute == 'clients')? 'class="active"': '';?>><a href="<?=Url::to(['clients/index', 'sort' => '-id'])?>"><?=FA::i('user')?> Клиенты</a></li >
                                    <li <?=($requestedRoute == 'staff')? 'class="active"': '';?>><a href="<?=Url::to(['staff/index', 'sort' => '-id'])?>"><?=FA::i('users')?> Сотрудники</a></li>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><?= FA::i('cog') ?> Справочники <?= FA::i('angle-down') ?></a>
                                        <ul class="dropdown-menu">
                                            <li <?=($requestedRoute == 'brand')? 'class="active"': '';?>><a href="<?=Url::to(['brand/index', 'sort' => '-id'])?>"> Марки</a></li>
                                            <li <?=($requestedRoute == 'option-value')? 'class="active"': '';?>><a href="<?=Url::to(['option-value/index', 'sort' => '-id'])?>"> Опции для машины</a></li>

                                            <li <?=($requestedRoute == 'expenses-categories')? 'class="active"': '';?>><a href="<?=Url::to(['expenses-categories/index'])  ?>"> Типы расходов</a></li>
                                        </ul>
                                    </li>
                                  


                                    <li <?=($requestedRoute == 'expenses')? 'class="active"': '';?>><a href="<?=Url::to(['expenses/index', 'sort' => '-id'])?>"><?=FA::i('money')?> Расходы</a></li>
                                    <li <?=($requestedRoute == 'profit')? 'class="active"': '';?>><a href="<?=Url::to(['profit/index', 'sort' => '-id'])?>"><?=FA::i('money')?> Приходы</a></li>
                                    <!-- <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><?= FA::i('cog') ?> Опции <?= FA::i('angle-down') ?></a>
                                        <ul class="dropdown-menu">
                                            <li <?=($requestedRoute == 'option-group')? 'class="active"': '';?>><a href="<?=Url::to(['option-group/index', 'sort' => '-id'])?>"> Группы</a></li>
                                            <li <?=($requestedRoute == 'option-value')? 'class="active"': '';?>><a href="<?=Url::to(['option-value/index', 'sort' => '-id'])?>"> Опции</a></li>
                                        </ul></li> -->
                                    <?php
                                    $prod_sort = '-id';
                                    if($product_count) $prod_sort = 'is_moderated';
                                    $reviews_sort = '-id';
                                    if($reviews) $reviews_sort = 'is_moderated';
                                    $questions_sort = '';
                                    if($questions) $questions_sort = 'is_moderated';
                                    if($answers) $questions_sort = 'is_moderated';
                                    ?>
                                    <!-- <li <?=($requestedRoute == 'review')? 'class="active"': '';?>><a href="<?=Url::to(['review/index', 'sort' => $reviews_sort])?>"><?=FA::i('comment-o')?> Отзывы <?=($reviews)?'<span class="badge">'.$reviews.'</span>':'' ?></a></li> -->
                                    <!-- <li <?=($requestedRoute == 'forum')? 'class="active"': '';?>><a href="<?=Url::to(['forum/index', 'sort' => $questions_sort])?>"><?=FA::i('comments')?> Форум <?=($questions)?'<span class="badge">'.$questions.'</span>':'' ?> <?=($answers)?'<span class="badge"> <i class="fa fa-comment-o"></i> '.$answers.'</span>':'' ?></a></li> -->
                                    <!-- <li <?=($requestedRoute == 'city')? 'class="active"': '';?>><a href="<?=Url::to(['city/index', 'sort' => 'order'])?>"><?=FA::i('map')?> Города</a></li> -->
                                    <!-- <li <?=($requestedRoute == 'radar')? 'class="active"': '';?>><a href="<?=Url::to(['radar/index'])?>"><?=FA::i('podcast')?> Радары</a></li> -->
                                    <!-- <li <?=($requestedRoute == 'news')? 'class="active"': '';?>><a href="<?=Url::to(['news/index', 'sort' => '-id'])?>"><?=FA::i('newspaper-o')?> Новости</a></li> -->
                                    <!-- <li <?=($requestedRoute == 'banner')? 'class="active"': '';?>><a href="<?=Url::to(['banner/index', 'sort' => '-id'])?>"><?=FA::i('image')?> Баннеры</a></li> -->
                                    <!-- <li <?=($requestedRoute == 'static-page-category')? 'class="active"': '';?>><a href="<?=Url::to(['static-page-category/index', 'sort' => '-id'])?>"><?=FA::i('list')?> Категории страниц</a></li> -->
                                    <!-- <li <?=($requestedRoute == 'static-page')? 'class="active"': '';?>><a href="<?=Url::to(['static-page/index', 'sort' => '-id'])?>"><?=FA::i('wpforms')?> Страницы</a></li> -->
                                    <li class="dropdown">
                                        <!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><?= FA::i('user-circle-o') ?> Пользователи <?= FA::i('angle-down') ?></a> -->
                                        <!-- <ul class="dropdown-menu">
                                            <li <?=($requestedRoute == 'admin')? 'class="active"': '';?>><a href="<?=Url::to(['admin/index', 'sort' => '-id'])?>"> Админы</a></li>
                                            <li <?=($requestedRoute == 'seller')? 'class="active"': '';?>><a href="<?=Url::to(['seller/index', 'sort' => '-id'])?>"> Юр.лица</a></li>
                                            <li <?=($requestedRoute == 'user' || $requestedRoute == 'announcement')? 'class="active"': '';?>><a href="<?=Url::to(['user/index', 'sort' => '-id'])?>"> Пользователи</a></li>
                                        </ul></li> -->
                                    <!-- <li <?=($requestedRoute == 'social')? 'class="active"': '';?>><a href="<?=Url::to(['social/index', 'sort' => '-id'])?>"><?=FA::i('facebook-square')?> Соц. странички</a></li> -->
                                    <!-- <li <?=($requestedRoute == 'message')? 'class="active"': '';?>><a href="<?=Url::to(['message/index', 'sort' => '-id'])?>"><?=FA::i('globe')?> Перевод сайта</a></li> -->
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
               
                            <?php if( Yii::$app->session->hasFlash('success') ): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo Yii::$app->session->getFlash('success'); ?>
                                </div>
                            <?php endif;?>
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
                <div class="col-sm-12 text-center">
                </div>
                <div class="col-sm-12 text-center">
                    <p>
                        <?= Yii::t('common', 'powered') ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>
<?php } else { ?>
    <footer class="footer border-top ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- <p class="pull-right">
                        &copy; <?= Yii::$app->params['appName'] ?> <span class="hidden-xs"><?= ((date('Y') > 2017) ? '2017-' : '') . date('Y') ?></span>
                    </p> -->
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
