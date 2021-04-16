<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 12.10.2017
 * Time: 16:34
 */
use common\models\OptionGroup;
use common\models\OptionValue;
use frontend\widgets\WProduct;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('frontend', 'Purchase').' #'.$order->id;
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
                        <smal class="pull-right fsz18px text-secondary"><?=date('d.m.Y H:i:s', $order->created_at)?></smal>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                            <div class="white-block">
                            <div class="order_body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?=Yii::t('frontend', 'Shop')?>:<br>
                                        <a href="<?= Url::to(['shop/index', 'id' => $order->shop->url]) ?>">
                                            <strong><?=$order->shop->name?></strong>
                                        </a>

                                        <?php if($order->isComplete && $order->comment_rate == 0) { ?>
                                        <br>
                                        <a href="<?=Url::to(['user/review', 'id' => $order->id, 'type' => 'shop'])?>" class="text-secondary"><?=FA::i('comment')?> <?=Yii::t('frontend', 'Add review')?></a>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-center">
                                            <?php if($order->checkStatus == 4) { ?>
                                            <span class="text-success"><?=Yii::t('frontend', 'Order ready')?></span>
                                                <br>
                                                <span class="text-success"><?=$order->delivery->translate->description?></span>
                                            <?php } else { ?>
                                                <?=Yii::t('frontend', 'Status')?>: <span class="text-<?=$statuses[$order->checkStatus][1]?>"><?=Yii::t('frontend', $statuses[$order->checkStatus][0])?></span>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="separator"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12" >
                                                <?php foreach ($order->orderProduct as $item) { ?>
                                                    <div class="order_product_row">
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <img src="<?=$item->product->mainImage->image?>" alt="<?=$item->product->translate->name?>" class="img-responsive center-block">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <p>
                                                                    <br>
                                                                    <a href="<?=Url::to(['product/index', 'id' => $item->product->url])?>"><?=$item->product->translate->name?>
                                                                        <?php if($item->product->articul !== '') { ?><br><span class="badge"><?=$item->product->articul?></span><?php } ?>
                                                                    </a>
                                                                    <?php if($order->isComplete && $item->comment_rate == 0) { ?>
                                                                        <br>
                                                                        <a href="<?=Url::to(['user/review', 'id' => $item->id, 'type' => 'product'])?>" class="text-secondary"><?=FA::i('comment')?> <?=Yii::t('frontend', 'Add review')?></a>
                                                                    <?php } ?>
                                                                </p>
                                                                <?php if($item->options != 'null') {
                                                                    $options = json_decode($item->options)
                                                                    ?>
                                                                    <?php foreach ($options as $group_id => $option_id) { ?>
                                                                        <p>
                                                                            <?=(OptionGroup::findOne($group_id))->translate->name?>: <?=(OptionValue::findOne($option_id))->translate->name?>
                                                                        </p>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <p class="text-secondary">
                                                                    <br>
                                                                    <?=$item->showPrice?>
                                                                    <br>
                                                                    x<?=$item->amount?><?=$item->product->unit->name?>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="text-secondary">
                                                                    <br>
                                                                    <?=$item->showSum?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p><br></p>
                                <div class="separator"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 "  >
                                                <p>
                                                    <?=$order->name?><br>
                                                    <?=$order->phone?><br>
                                                    <?=$order->email?><br>
                                                </p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>
                                                    <?php if($order->delivery_id > 0) { ?>
                                                        <?=$order->address?>
                                                    <?php } else { ?>
                                                        <?=Yii::t('frontend', 'Pickup')?>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p><br></p>
                                <div class="separator"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 text-center"  >
                                                <?=Yii::t('frontend', 'Cost')?>:<br>
                                                <strong class="text-secondary"><?=$order->showPrice?></strong><br>
                                                <?php if ($order->pay_method == 1) { ?>
                                                    <span class="text-primary">
                                                        <?= Yii::t('frontend', 'Online') ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="text-primary">
                                                        <?= Yii::t('frontend', 'Cash') ?>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php if(preg_match('#user/purchases#i', Yii::$app->request->referrer)) { ?>
                                                    <a href="<?=Yii::$app->request->referrer ?>" class="btn btn-secondary btn-order"><?=FA::i('arrow-left')?> <?=Yii::t('frontend', 'Back')?></a>
                                                <?php } else { ?>
                                                    <a href="<?=Url::to(['user/purchases'])?>" class="btn btn-secondary btn-order"><?=FA::i('arrow-left')?> <?=Yii::t('frontend', 'Back')?></a>
                                                <?php } ?>
                                                <?php if($order->canCancel) { ?>
                                                    <div class="div-inline">
                                                    <form action="<?=Url::to(['user/purchase-delete'])?>" method="post">
                                                        <input type="hidden" name="id" value="<?=$order->id?>">
                                                        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                                                        <button href="#" class="btn btn-danger btn-order"><?=FA::i('remove')?> <?=Yii::t('frontend', 'Cancel')?></button>
                                                    </form>
                                                    </div>
                                                <?php } ?>
                                                <?php if($order->canPay) { ?>
                                                    <a href="#" class="btn btn-success disabled btn-order"><?=FA::i('credit-card')?> <?=Yii::t('frontend', 'Pay')?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                </div>
            </div>
    </div>
</div>
<?= WProduct::widget(['key' => 'recent']) ?>
</div>
