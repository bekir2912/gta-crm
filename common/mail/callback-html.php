<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$userLink = Yii::$app->urlManager->createAbsoluteUrl(['user/purchases']);
$shopLink = Yii::$app->urlManager->createAbsoluteUrl(['user/purchases']);
?>
<?php //if($type == 'user') { ?>
<!--    <div class="password-reset">-->
<!--        <p>Ваш заказ принят</p>-->
<!---->
<!--        Детали заказ можете посмотреть в <a href="--><?//=$userLink?><!--">личном кабинете</a>.-->
<!--    </div>-->
<?php //} ?>
<?php if($type == 'shop') { ?>
    <div class="password-reset">
        <h3>Обратный звонок</h3>

        <p>Зайдите в панель управления для просмотра деталей.</p>
    </div>
<?php } ?>
