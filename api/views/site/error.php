<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$this->title = Yii::t('frontend', 'Error');
?>
<div class="white-block">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <?= Html::encode($this->title) ?>
            </div>
        </div>
    </div>
    <div class="news_body">
    <p class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </p>
    </div>
</div>