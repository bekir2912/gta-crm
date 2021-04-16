<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $news->translate->name;


$this->registerMetaTag([
    'name' => 'description',
    'content' => Html::encode(strip_tags($news->translate->meta_description)),
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Html::encode(strip_tags($news->translate->meta_keys)),
]);

?>
<a href="<?=Url::to(['news/list'])?>" class="all_news_link"><?=Yii::t('frontend', 'All news')?></a>
<div class="news_block">
    <div class="row">
        <div class="col-md-12">
            <h4 class="news_block_title"><?=$this->title?>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="news_body">
                <img src="<?= $news->translate->image ?>"
                     alt="<?= $news->translate->name ?>" class="img-responsive center-block" style="float: left;margin: 0 20px 20px 0;">
                <?= $news->translate->text ?>
                <br>
                <p class="shell_news_date"><?= date('d.m.Y', $news->created_at) ?></p>
            </div>
        </div>
    </div>
</div>