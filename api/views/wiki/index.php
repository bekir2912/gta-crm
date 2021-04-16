<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $brand->name;


?>
<a href="<?= Url::to(['wiki/list', 'cat_id' => $brand->category_id]) ?>"
   class="all_news_link"><?= Yii::t('frontend', 'All brands') ?></a>
<div class="news_block">
    <div class="row">
        <div class="col-md-12">
            <h4 class="news_block_title"><?= $brand->name ?>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($brand->lineups)) { ?>
                <div class="SubcategoriesList Subcategories">
                    <?php for ($i = 0; $i < count($brand->lineups); $i++) { ?>
                        <div class="SubcategoriesList-item">
                            <a class="navigation__dropdown-link"
                               href="<?= Url::to(['wiki/show', 'id' => $brand->lineups[$i]->id]) ?>"><?= $brand->lineups[$i]->translate->name ?></a>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="col-md-12 text-center">
                    <span class="text-muted">
                        <?= Yii::t('frontend', 'Nothing to show') ?>
                    </span>
                </div>
            <?php } ?>
        </div>
    </div>
</div>