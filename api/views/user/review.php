
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
        </div>
        <div class="row">
            <div class="col-md-12">

                <?php $form = ActiveForm::begin(); ?>
                <?php if($model->type == 'shop') { ?>
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

                                                <div class="user-review">

                                                    <?= $form->field($model, 'rate')->dropDownList(['1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10]) ?>
                                                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                                                    <?= $form->field($model, 'review')->textarea() ?>
                                                    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

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
                                                    <button class="btn btn-primary btn-order"><?=FA::i('check')?> <?=Yii::t('frontend', 'Save')?></button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php if($model->type == 'product') { ?>
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

                                                <div class="user-review">

                                                    <?= $form->field($model, 'rate')->dropDownList(['1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10]) ?>
                                                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                                                    <?= $form->field($model, 'review')->textarea() ?>
                                                    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

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
                                                    <button class="btn btn-primary btn-order"><?=FA::i('check')?> <?=Yii::t('frontend', 'Save')?></button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php } ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
<?= WProduct::widget(['key' => 'recent']) ?>

</div>