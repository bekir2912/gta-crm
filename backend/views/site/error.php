<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Ошибка';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="page-header"><?= Html::encode($this->title) ?></div>

                <div class="alert alert-danger">
                    Страница не найдена.
                </div>
            </div>
        </div>
    </div>
</div>