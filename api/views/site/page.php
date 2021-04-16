<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Html::encode($page->translate->name);

$this->registerMetaTag([
    'name' => 'description',
    'content' => Html::encode(strip_tags($page->translate->meta_description)),
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Html::encode(strip_tags($page->translate->meta_keys)),
]);
?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <strong><?= $this->title ?></strong>
            </div>
        </div>
        <div class="col-md-12">
            <div class="news_body">
                <?= $page->translate->text ?>
            </div>
        </div>
    </div>
