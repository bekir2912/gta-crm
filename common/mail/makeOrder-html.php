<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$userLink = Yii::$app->urlManager->createAbsoluteUrl(['user/purchases']);
$shopLink = Yii::$app->urlManager->createAbsoluteUrl(['user/purchases']);
?>
<?php if($type == 'user') { ?>
    <div class="password-reset">
        <h3>Ваш заказ принят</h3>

        <p>Детали заказ можете посмотреть в <a href="<?=$userLink?>">личном кабинете</a>.</p>
    </div>
<?php } ?>
<?php if($type == 'shop') { ?>
    <div class="password-reset">
        <h3>Новый заказ</h3>

        <p>Зайдите в панель управления для просмотра деталей.</p>
    </div>
<?php } ?>
