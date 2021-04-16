<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 12.10.2017
 * Time: 16:34
 */
use frontend\widgets\WProduct;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Yii::t('frontend', 'Reviews');
?>
<div class="container">
<div class="row">
        <div class="col-sm-3">
            <div class="white-block">
                <div class="news_body">
                    <?php require_once('menu.php') ?>
                </div>
            </div>
        </div>
    <div class="col-sm-9">

        <div class="white-block">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <?= $this->title ?>
                    </div>
                    <?php  ?>
                </div>
            </div>
            <?php if(empty($orders)) { ?>
            <div class="white-block">
                <div class="row">
                    <div class="col-md-12">
                <div class="news_body">
                    <p class="text-muted">
                        <?= Yii::t('frontend', 'No reviews') ?>
                    </p>
                </div>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if(!empty($orders)) { ?>
                        <?php foreach ($orders as $order) { ?>
                            <div class="white-block">
                            <div class="order_body">
                                <div class="row">
                                    <div class="col-sm-2 col-md-1">
                                        <a href="<?= Url::to(['shop/index', 'id' => $order->shop->url]) ?>">
                                            <img src="<?=$order->shop->logo?>" alt="<?=$order->shop->name?>" class="img-responsive center-block">
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-9">
                                        <?=Yii::t('frontend', 'Shop')?>:<br>
                                        <a href="<?= Url::to(['shop/index', 'id' => $order->shop->url]) ?>">
                                            <strong><?=$order->shop->name?></strong>
                                        </a>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <p class="text-secondary"><?= FA::i('star') ?> <?=$order->shop->rate?> <span class="text-primary"><?=FA::i('user-circle-o').' '.$order->shop->reviewsCount?></span></p>
                                    </div>
                                </div>
                                <br>
                                <div class="separator"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="review_block">
                                                    <div class="pull-right review_rate">
                                                        <span class="text-secondary"><?=FA::i('star')?> <?=$order->comment_rate?></span>
                                                    </div>
                                                    <?=$order->comment?>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 text-center"  >
                                                <p>
                                                    <?php if($order->comment_status == 0) { ?>
                                                        <span class="text-info"><?=FA::i('clock-o')?> <?=Yii::t('common', 'Moderating')?></span>
                                                    <?php } elseif($order->comment_status == -1) { ?>
                                                        <span class="text-danger"><?=FA::i('remove')?> <?=Yii::t('common', 'Blocked')?></span>
                                                    <?php } else { ?>
                                                    <span class="text-success"><?=FA::i('check')?> <?=Yii::t('common', 'Published')?></span>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php if($order->comment_status != 1) { ?>
                                                    <a href="<?=Url::to(['user/review', 'id' => $order->id, 'type' => 'shop'])?>" class="btn btn-primary btn-order"><?=FA::i('pencil')?> <?=Yii::t('common', 'Update')?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if(!empty($products)) { ?>
                        <?php foreach ($products as $product) { ?>
                            <div class="white-block">
                                <div class="order_body">
                                    <div class="row">
                                        <div class="col-sm-2 col-md-1">
                                            <a href="<?= Url::to(['product/index', 'id' => $product->product->url]) ?>">
                                                <img src="<?=$product->product->mainImage->image?>" alt="<?=$product->product->translate->name?>" class="img-responsive center-block">
                                            </a>
                                        </div>
                                        <div class="col-sm-8 col-md-9">
                                            <?=Yii::t('frontend', 'Product')?>:<br>
                                            <a href="<?= Url::to(['product/index', 'id' => $product->product->url]) ?>">
                                                <strong><?=$product->product->translate->name?></strong>
                                            </a>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <p class="text-secondary"><?= FA::i('star') ?> <?=$product->product->rate?> <span class="text-primary"><?=FA::i('user-circle-o').' '.$product->product->reviewsCount?></span></p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="separator"></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="review_block">
                                                        <div class="pull-right review_rate">
                                                            <span class="text-secondary"><?=FA::i('star')?> <?=$product->comment_rate?></span>
                                                        </div>
                                                        <?=$product->comment?>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6 text-center"  >
                                                    <p>
                                                        <?php if($product->comment_status == 0) { ?>
                                                            <span class="text-info"><?=FA::i('clock-o')?> <?=Yii::t('common', 'Moderating')?></span>
                                                        <?php } elseif($product->comment_status == -1) { ?>
                                                            <span class="text-danger"><?=FA::i('remove')?> <?=Yii::t('common', 'Blocked')?></span>
                                                        <?php } else { ?>
                                                            <span class="text-success"><?=FA::i('check')?> <?=Yii::t('common', 'Published')?></span>
                                                        <?php } ?>
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php if($product->comment_status != 1) { ?>
                                                        <a href="<?=Url::to(['user/review', 'id' => $product->id, 'type' => 'product'])?>" class="btn btn-primary btn-order"><?=FA::i('pencil')?> <?=Yii::t('common', 'Update')?></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>

    </div>
</div>
<?= WProduct::widget(['key' => 'recent']) ?>
</div>