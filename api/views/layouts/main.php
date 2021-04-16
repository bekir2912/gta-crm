<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$banners = \common\models\Banner::find()->where(['status' => 1, 'type' => 0])->andWhere(['>', 'expires_in', time()])->orderBy('order')->all();
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
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="content-wrapper">
    <?= $this->render('header.php') ?>
    <main class="middle">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <?= $content ?>
                </div>
                <div class="col-md-3 hidden-sm hidden-xs">
                    <div class="banner-block">
                        <?php for ($i = 0; $i < count($banners); $i++) { ?>
                            <div class="banner__item">
                                <?php if ($banners[$i]->translate->url != '') { ?> <a href="<?=Url::to(['site/away', 'url' => $banners[$i]->translate->url])?>" target="_blank"> <?php } ?>
                                    <img src="<?=$banners[$i]->translate->image?>" class="banner__img" title="<?=$banners[$i]->translate->name?>">
                                    <?php if ($banners[$i]->translate->url != '') { ?> </a> <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="operator">
                            <img src="/uploads/site/operator.png" class="operator__icon">
                            <h4 class="operator__heading">
                                <?=Yii::t('frontend', 'Support')?>:
                            </h4>
                            <p class="operator__text">
                                <?=Yii::$app->params['client_support_service']?>
                            </p>
                            <p class="operator__text">
                                <?=Yii::$app->params['infoEmail']?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->render('footer.php') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
