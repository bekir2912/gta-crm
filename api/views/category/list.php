<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 14.10.2017
 * Time: 2:34
 */
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Yii::t('frontend', 'Catalogue');

?>
<div class="white-block">
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <?= $this->title ?>
        </div>
    </div>
        <div class="col-md-12">
            <div class="row" style="margin: 0;">
                <?php if (!empty($categories)) { ?>
                    <?php for ($i = 0; $i < count($categories); $i++) { ?>
                        <div class="col-md-12" style="padding: 0;">
                            <a href="<?= Url::to(['category/index', 'id' => $categories[$i]->url]) ?>" class="product-link">
                                <div class="product-cart">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="<?= $categories[$i]->translate->image ?>"
                                                 alt="<?= $categories[$i]->translate->name ?>" class="img-responsive">
                                        </div>
                                        <div class="col-sm-9">
                                            <h4 class="text-secondary"><?= $categories[$i]->translate->name ?></h4>
                                            <div>
                                                <?= nl2br($categories[$i]->translate->description) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p><?= Yii::t('frontend', 'No category') ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="text-center">
                <?php echo LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
            </div>
        </div>
</div>
</div>