<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($news)) {
    ?>
    <div class="news_block">
        <div class="row">
            <div class="col-md-12">
                <h4 class="news_block_title"><?=Yii::t('frontend', 'News')?>
                    <small class="pull-right"><a href="<?=Url::to(['news/list'])?>" class="all_news_link"><?=Yii::t('frontend', 'All news')?></a></small>
                </h4>
            </div>
        </div>
        <div class="row">
            <?php for ($i = 0; $i < count($news); $i++) { ?>
                <div class="col-md-3 col-sm-6">
                    <a href="<?=Url::to(['news/index', 'id' => $news[$i]->url])?>" class="news-link">
                        <div class="news-cart">
                            <img src="<?= $news[$i]->translate->image ?>"
                                 alt="<?= $news[$i]->translate->name ?>" class="img-responsive">
                            <p class="shell_news_title "><?= $news[$i]->translate->name ?></p>
                            <p class="shell_news_anons "><?= $news[$i]->translate->short ?></p>
                            <p class="shell_news_date ">
                                <?= date('d.m.Y', $news[$i]->created_at) ?>
                            </p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>