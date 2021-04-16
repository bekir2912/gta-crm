<?php

use yii\helpers\Html;

/** @var \yii\web\View $this view component instance */
/** @var \yii\mail\MessageInterface $message the message being composed */
/** @var string $content main view render result */
?>

<?php $this->beginPage() ?>
<?php $this->beginBody() ?>
<?=Yii::$app->name?>
------------------------------------------------
<?= $content ?>
------------------------------------------------
&copy; <?=Yii::$app->name?>. Все права защищены.
<?php $this->endBody() ?>
<?php $this->endPage() ?>
