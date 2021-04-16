<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 14.10.2017
 * Time: 2:34
 */

use common\models\Category;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Yii::t('frontend', 'Wiki');

$cats = Category::find()->where(['status' => 1, 'parent_id' => null, 'on_main' => 0, 'spec' => 0])->orderBy('order')->all();
?>

<section class="announcements" style="margin-bottom: 25px;">
    <?php if (!empty($cats)) { ?>
        <div class="announcements__category">
            <ul class="category__list">
                <?php foreach ($cats as $cat) { ?>
                    <li class="category__item">
                        <a href="<?= Url::current(['cat_id' => $cat->id]) ?>"
                           class="category__link <?= ($filter_cat && ($filter_cat->id == $cat->id)) ? ' category__link--active' : '' ?>">
                            <?= $cat->translate->name ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <div class="clearfix add-announcement-block"></div>
</section>
    <div class="row">
        <?php if (!empty($brands)) { ?>
            <?php for ($i = 0; $i < count($brands); $i++) { ?>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <a href="<?=Url::to(['wiki/index', 'id' => $brands[$i]->id])?>" class="">
                        <div style="margin-bottom: 20px;">
                            <img src="<?= $brands[$i]->logo ?>"
                                 alt="<?= $brands[$i]->name ?>" class="img-responsive" >
                            <p class="shell_news_title text-center"><?= $brands[$i]->name ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
        <div class="col-md-12 text-center">
            <span class="text-muted">
                <?=Yii::t('frontend', 'Nothing to show')?>
            </span>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <?= LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        </div>
    </div>