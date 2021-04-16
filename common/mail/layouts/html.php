<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <table style="width: 100%">
        <tr>
            <td style="text-align: center;background: #eeeeee;padding: 10px 0;">
                <img src="<?=Yii::$app->params['domain'];?>/uploads/site/logo_red.png" alt="<?=Yii::$app->name?>" style="margin: 0 auto;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;background: #fff;padding: 10px;">
                <?= $content ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;background: #eeeeee;padding: 10px;">
                &copy; <a href="<?=Yii::$app->params['domain']?>"><?=Yii::$app->name?></a>. Все права защищены.
            </td>
        </tr>
    </table>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
