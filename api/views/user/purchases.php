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

$this->title = Yii::t('frontend', 'Purchases');
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
                        <?= Yii::t('frontend', 'No orders') ?>
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
                                    <div class="col-sm-4">
                                        <?=Yii::t('frontend', 'Order number')?>: <strong class="text-secondary"><?=$order->id?></strong><br>
                                        <?=Yii::t('frontend', 'Order date')?>: <strong class="text-secondary"><?=date('d.m.Y H:i:s', $order->created_at)?></strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <?=Yii::t('frontend', 'Shop')?>:<br>
                                        <a href="<?= Url::to(['shop/index', 'id' => $order->shop->url]) ?>">
                                            <strong><?=$order->shop->name?></strong>
                                        </a>
                                    </div>
                                    <div class="col-sm-4">
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
                                </div>
                                <div class="separator"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6" >
                                                <?php foreach ($order->orderProduct as $item) { ?>
                                                    <div class="order_product_row" style="border: 0">
                                                        <p>
                                                            <span class="pull-left"><img src="<?=$item->product->mainImage->image?>" alt="<?=$item->product->translate->name?>" style="max-width: 75px;"></span><?=$item->product->translate->name?>
                                                            <?php if($item->product->articul !== '') { ?><br><span class="badge"><?=$item->product->articul?></span><?php } ?>
                                                            <br>
                                                            x <?=$item->amount?><?=$item->product->unit->name?>
                                                            <br>
                                                        <span class="clearfix"></span>
                                                        </p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-6" >
                                                <p>
                                                    <?=$order->name?><br>
                                                    <?=$order->phone?><br>
                                                    <?=$order->email?><br>
                                                </p>
                                                <div class="separator"></div>
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
                                                <p>
                                                    <?php if($order->checkStatus == 4) { ?>
                                                        <span class="text-success"><?=Yii::t('frontend', 'Order ready')?></span>
                                                        <br>
                                                        <span class="text-success"><?=$order->delivery->translate->description?></span>
                                                    <?php } else { ?>
                                                        <?=Yii::t('frontend', 'Status')?>: <span class="text-<?=$statuses[$order->checkStatus][1]?>"><?=Yii::t('frontend', $statuses[$order->checkStatus][0])?></span>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="<?=Url::to(['user/purchase', 'id' => $order->id])?>" class="btn btn-primary btn-order"><?=FA::i('list-alt')?> <?=Yii::t('frontend', 'Details')?></a>
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
                                                <?php if($order->isComplete) { ?>
                                                    <div class="dropdown" style="display: inline-block;">
                                                        <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-secondary btn-order"><?=FA::i('comment')?> <?=Yii::t('frontend', 'Add review')?></a>
                                                        <ul class="dropdown-menu dropdown-menu-right review-dropdown" aria-labelledby="dLabel">
                                                            <li>
                                                                <a href="<?=Url::to(['user/review', 'id' => $order->id, 'type' => 'shop'])?>">
                                                                    <?=Yii::t('frontend', 'About shop')?>: <?=$order->shop->name?></a>
                                                            </li>
                                                            <li role="separator" class="divider"></li>
                                                            <li><strong style="padding: 3px 20px;"><?=Yii::t('frontend', 'About product')?></strong></li>
                                                            <?php foreach ($order->orderProduct as $item) { ?>
                                                                <li>
                                                                    <a href="<?=Url::to(['user/review', 'id' => $item->id, 'type' => 'product'])?>"><?=$item->product->translate->name?></a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
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

                <div class="col-md-12">
                    <div class="text-center">
                        <?php echo LinkPager::widget([
                            'pagination' => $pages,
                        ]); ?>
                    </div>
                </div>
            </div>

    </div>
</div>
<?= WProduct::widget(['key' => 'recent']) ?>
</div>
