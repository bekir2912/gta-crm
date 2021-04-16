<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$userLink = Yii::$app->urlManager->createAbsoluteUrl(['user/purchases']);
?>
<?php if($type == 'user') { ?>
        Ваш заказ принят

        Детали заказ можете посмотреть в личном кабинете.
        <?=$userLink?>
<?php } ?>
<?php if($type == 'shop') { ?>
        Новый заказ

        Зайдите в панель управления для просмотра деталей.
<?php } ?>