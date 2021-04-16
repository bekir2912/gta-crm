<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <h3>Здравствуйте, новое обращение в тез поддержку.</h3>
    <br>
    <p>Тип обращения: <?=$type?></p>
    <br>
    <p>Имя: <?=$name?></p>
    <br>
    <p>Телефон или E-mail: <?=$contact?></p>
    <p>Текст обращения: <?=$text?></p>
</div>
