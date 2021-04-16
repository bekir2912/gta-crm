<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 14.10.2017
 * Time: 2:34
 */
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Yii::t('frontend', 'News');

?>
<?php if (!empty($news)) { ?>
<div class="news_block">
    <div class="row">
        <div class="col-md-12">
            <h4 class="news_block_title"><?=Yii::t('frontend', 'News')?>
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
                        <p class="shell_news_anons "><?= $news[$i]->translate->name ?></p>
                        <p class="shell_news_date ">
                            <?= date('d.m.Y', $news[$i]->created_at) ?>
                        </p>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <?php echo LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>