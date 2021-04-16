<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <h3>Здравствуйте, <?= Html::encode($user->name) ?></h3>

    <p>Вы получили это письмо, так как был отправлен запрос на восстановление пароля для Вашей учетной записи.</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
