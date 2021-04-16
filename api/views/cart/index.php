<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 08.10.2017
 * Time: 4:05
 */
use common\models\UserAddress;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;
use yii\web\View;

$this->title = Yii::t('frontend', 'Shopping Cart');

?>

<?= newerton\fancybox3\FancyBox::widget(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header product-widget-header" style="padding-top: 0">
                <?=$this->title?>
            </div>
        </div>
    </div>
<?php if (!empty($cart)) { ?>
    <div class="row">
        <div class="col-md-12">
            <div id="currency" data-currency="<?= Yii::t('frontend', 'Currency') ?>"></div>
            <form action="<?= Url::to(['order/make']) ?>" method="post">
                <?php $total_price = 0;
                foreach ($cart as $shop_id => $products) {
                    $shop_price = 0; ?>
                <div class="white-block">
                    <div class="cart_shop" id="shop_<?= $shop_id ?>">
                        <h4 ><a href="<?=Url::to(['shop/index' ,'id' => $shops[$shop_id]->url])?>" class="text-primary"><?= $shops[$shop_id]->name ?></a>
                             | <small><?= '<span class="text-secondary">'.FA::i('star') .' '.$shops[$shop_id]->rate.'</span> <span class="text-primary">'.FA::i('user-circle-o').' '.$shops[$shop_id]->reviewsCount.'</span>'?></small>
                        </h4>
                        <div class="separator"></div>
                        <?php foreach ($products as $i => $product) {

                            if(($product->sale->value > 0)) {
                                if($product->sale->type == 0){
                                    $prod_price = $product->price - ($product->price * $product->sale->value);
                                }
                                else {
                                    $prod_price = $product->price - $product->sale->value;
                                }
                            }
                            else {
                                $prod_price = $product->price;
                            }

                            $ws = json_decode($product->wholesale, true);
                            $min = 1;
                            if($product->price_type == 1) {
                                $min = (integer) key($ws);
                                $prod_price = (int) $ws[key($ws)];
                            }
                            elseif($product->price_type == 2 && $product->price == 0) {
                                $min = (integer) key($ws);
                                $prod_price = (integer) $ws[key($ws)];
                            }

                            $counts[$i] = ($min >= $counts[$i])? $min: $counts[$i]
                            ?>
                            <div id="pr_<?= $product->id . '_' . $i ?>" class="product_details">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <img src="<?= $product->mainImage->image ?>"
                                             alt="<?= $product->translate->name ?>" class="img-responsive center-block">
                                    </div>
                                    <div class="col-sm-4">
                                        <a class="fsz18px cart_link"  data-pjax="0"
                                           href="<?= Url::to(['product/index', 'id' => $product->url]) ?>"><?= $product->translate->name ?>
                                            <?php if($product->articul !== '') { ?><br><span class="badge">#<?=$product->articul?></span><?php } ?>
                                        </a>
                                        <br>
                                        <a class="cart_link"
                                           href="<?= Url::to(['category/index', 'id' => $product->category->url]) ?>"><?= $product->category->translate->name ?></a>
                                        <br>
                                        <br>
                                        <?php
                                        $opt_price = 0;
                                        if (isset($options[$i])) { ?>
                                            <?php foreach ($options[$i] as $option) { ?>
                                                <p><span class="text-muted"><?= $option['groupName'] ?>
                                                        :</span> <?= $option['valueName'] ?></p>
                                                <?php $opt_price += $option['price'];
                                            }
                                            if(!empty($ws)){
                                                foreach ($ws as $min_cnt => $pprice) {

                                                    if($counts[$i] >= $min_cnt) {
                                                        $prod_price = $pprice;
                                                    }

                                                    $ws[(integer) $min_cnt] = (integer) ($pprice + $opt_price);
                                                }
                                            }
                                            ?>
                                        <?php }
                                        $product->wholesale = json_encode($ws);
                                        ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="btn-group mt30">
                                            <a class="btn btn-danger center-block div-inline pc_minus"
                                               data-target="<?= $product->id . '_' . $i ?>"
                                               id="pc_m_<?= $product->id . '_' . $i ?>" <?=($min == $counts[$i])?'disabled="disabled"':''?>>-</a>
                                            <input type="hidden" name="Shop[<?= $shop_id ?>][<?= $i ?>][product_id]"
                                                   value="<?= $product->id ?>">
                                            <input type="hidden"
                                                   name="Shop[<?= $shop_id ?>][<?= $i ?>][product_options]"
                                                   value='<?= $options_json[$i] ?>'>
                                            <input type="text" class="product_count pull-left text-center"
                                                   name="Shop[<?= $shop_id ?>][<?= $i ?>][product_count]"
                                                   required="required"
                                                   data-min='<?= $min ?>'
                                                   id="pc_<?= $product->id . '_' . $i ?>" value="<?=$counts[$i]?>"
                                                   readonly="readonly"/>
                                            <a class="btn btn-success center-block div-inline pc_plus"
                                               data-target="<?= $product->id . '_' . $i ?>">+</a>
                                        </div>
                                        <?php if(!empty($product->unit)) { ?>
                                            <div class="text-center">
                                                <?=$product->unit->translate->name?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-3 pt-default">
                                        <h3 class="text-primary shop<?= $shop_id ?>_product"
                                            id="pp_<?= $product->id . '_' . $i ?>"
                                            data-price="<?= ($prod_price + $opt_price) ?>"
                                            data-value="<?= (($prod_price + $opt_price) * $counts[$i]) ?>"
                                            data-wholesale='<?= $product->wholesale ?>'
                                            data-target="<?= $shop_id ?>">
                                            <?php
                                            $prod_price_show = number_format((($prod_price + $opt_price) * $counts[$i]), Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
                                            $prod_price_show = preg_replace('/,00$/i', '', $prod_price_show);
                                            ?>
                                            <?= $prod_price_show . ' ' . Yii::t('frontend', 'Currency'); ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-danger center-block div-inline cart_delete_but"
                                       data-target="<?= $product->id . '_' . $i ?>"
                                       data-product='<?= $product->id . '_' . $options_json[$i] ?>'
                                       data-shop="<?= $shop_id ?>">
                                        <?= FA::i('remove') . ' ' . Yii::t('frontend', 'Delete') ?>
                                    </a>
                                </div>
                                <div class="separator"></div>
                            </div>
                            <?php $shop_price += (($prod_price + $opt_price) * $counts[$i]);
                        } ?>
                        <div class="row shop_details">
                            <div class="col-sm-12">
                                <div class="row">

                                        <?php if ($product->shop->info->address != '') { ?>
                                    <div class="col-sm-6">
                                            <strong><?= Yii::t('frontend', 'Shop address') ?>: </strong>
                                            <br>
                                        <?= nl2br($product->shop->info->address) ?><br>
                                            <?= (($product->shop->info->lat != "" && $product->shop->info->lng != "") ? '<a class="open_ajax" data-pjax="false" href="' . Url::to(['map/index', 'id' => $product->shop->id]) . '">' . Yii::t('frontend', 'Show on map') . '</a><br>' : '') ?>
                                            <br>
                                    </div>
                                        <?php } ?>

                                        <?php if ($product->shop->info->phone != '') { ?>
                                    <div class="col-sm-6">
                                            <strong><?= Yii::t('frontend', 'Shop phone') ?>: </strong>
                                            <br>
                                        <span id="phone">
                                        <a class="cursorPointer shop_phone" style="color: inherit;border-bottom: 1px dashed #3c3d3d" id="" data-shop="<?=$product->shop->id?>"><?=mb_strtolower(Yii::t('frontend', 'Show'));?></a>
                                    </span><br><br>
                                    </div>
                                        <?php } ?>
                                </div>
                                <div class="row">
                                        <?php if ($product->shop->info->scheduleForm  != '') { ?>
                                    <div class="col-sm-6">

                                    <strong><?= Yii::t('frontend', 'Schedule') ?>: </strong>
                                            <br>
                                        <a type="button" class="cursorPointer" data-toggle="modal" data-target="#schedule" style="color: inherit;border-bottom: 1px dashed #3c3d3d">
                                            <?=mb_strtolower(Yii::t('frontend', 'Show'));?>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="scheduleLabel">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body ">
                                                        <?= nl2br($product->shop->info->scheduleForm) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br><br>
                                    </div>
                                        <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" checked="checked"
                                               class="shop_delivery shop<?= $shop_id ?>_delivery"
                                               name="Shop[<?= $shop_id ?>][delivery_id]" value="0"
                                               data-target="<?= $shop_id ?>"
                                               data-price="0"/> <?= Yii::t('frontend', 'Pickup') ?>
                                    </label>
                                </div>

                                <?php if (!empty($product->shop->delivery)) { ?>
                                    <?php for ($i = 0; $i < count($product->shop->delivery); $i++) { ?>

                                        <div class="radio">
                                            <label>
                                                <input type="radio" class="shop_delivery shop<?= $shop_id ?>_delivery"
                                                       data-target="<?= $shop_id ?>"
                                                       data-delivery="<?= $product->shop->delivery[$i]->id ?>"
                                                       data-price="<?= $product->shop->delivery[$i]->price ?>"
                                                       name="Shop[<?= $shop_id ?>][delivery_id]"
                                                       value="<?= $product->shop->delivery[$i]->id ?>"/> <?= $product->shop->delivery[$i]->translate->method ?>
                                                <small class="text-success"><?= ($product->shop->delivery[$i]->price == 0) ? Yii::t('frontend', 'Free') : '+' . $product->shop->delivery[$i]->showPrice ?></small>
                                            </label>
                                        </div>
                                        <small class="sr-only"
                                               id="delivery_<?= $shop_id ?>_<?= $product->shop->delivery[$i]->id ?>"><?= $product->shop->delivery[$i]->translate->description ?>
                                            / <?= $product->shop->delivery[$i]->translate->schedule ?></small>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="col-sm-4">
                                <span class="text-primary fs24px shop_price" id="sp_<?= $shop_id ?>"  <?php

                                $shop_price_show = number_format($shop_price, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
                                $shop_price_show = preg_replace('/,00$/i', '', $shop_price_show);
                                ?>
                                      data-price="<?= $shop_price ?>"><?= $shop_price_show . ' ' . Yii::t('frontend', 'Currency'); ?></span>
                                <div id="delivery-desc_<?= $shop_id ?>"></div>
                            </div>
                            <div class="col-sm-4">
                                <input type="hidden" name="Shop[<?= $shop_id ?>][online_pay]" value="0"/>
                                <?php
                                $payments_json = json_decode($product->shop->payments);
                                $payments = (!empty($payments_json))?$payments_json  : [];
                                ?>
                                <?php if (!empty($payments)) { ?>
                                <div class="prod-filter-block">
                                    <?php foreach ($payments as $itt => $payment) { ?>
                                        <?php
                                        $pay_sys = \common\models\PaySystem::find()->where(['status' => 1, 'id' => $payment])->one();
                                        if (empty($pay_sys)) continue;
                                        ?>
                                        <div class="checkbox prod-filter-checkbox <?= ($itt == 0) ? 'active-prod-filter' : '' ?>">
                                            <label>
                                                <input type="radio"
                                                       class="product_filter_button"
                                                       name="Shop[<?= $shop_id ?>][which_pay]"
                                                       value="<?= $pay_sys->id ?>"
                                                    <?= ($itt == 0) ? 'checked="checked"' : '' ?>
                                                > <?= '<img src="' . $pay_sys->logo . '" alt="' . $pay_sys->name . '" data-toggle="tooltip" data-placement="top" title="' . $pay_sys->name . '"/>' ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php $total_price += $shop_price; } ?>
                <div class="cart_total">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <span class="text-success fs24px"><?= Yii::t('frontend', 'Total Price') . ': ' ?></span><span
                                        class="text-success fs24px"
                                        <?php

                                        $total_price_show = number_format($total_price, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
                                        $total_price_show = preg_replace('/,00$/i', '', $total_price_show);
                                        ?>
                                        id="total_price"><?= $total_price_show . ' ' . Yii::t('frontend', 'Currency') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3" id="change_class">
                                    <div class="form-group" id="address_group" style="display: none;">
                                        <label for="address"><?= Yii::t('frontend', 'Address') ?></label>
                                        <select name="User[address_id]" id="address_id" class="form-control">
                                            <option value="0"><?= Yii::t('frontend', 'New Address') ?></option>
                                            <?php $addresses = '<div class="sr-only" id="address_id_0"></div>'; ?>
                                            <?php if (Yii::$app->user->id) {
                                                $address = UserAddress::find()->where(['user_id' => Yii::$app->user->id])->all(); ?>
                                                <?php if (!empty($address)) {
                                                    for ($a = 0; $a < count($address); $a++) { ?>
                                                        <option value="<?=$address[$a]->id?>"><?=$address[$a]->name?></option>
                                                    <?php $addresses .= '<div class="sr-only" id="address_id_'.$address[$a]->id.'">'.$address[$a]->address.'</div>';} ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?=$addresses?>
                                        <textarea name="User[address]" id="address" cols="30" rows="4"
                                                  class="form-control" placeholder="<?=Yii::t('frontend', 'Address placeholder')?>"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label><?= Yii::t('frontend', 'Customer') ?></label>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="<?=Yii::$app->getUser()->identity->name?>" required="required"
                                                   name="User[name]"
                                                   placeholder="<?= Yii::t('frontend', 'Name') ?>">
                                        </div>
                                        <input type="text" class="form-control" value="<?=Yii::$app->getUser()->identity->phone? Yii::$app->getUser()->identity->phone: '+998';?>" required="required"
                                               name="User[phone]"
                                               placeholder="<?= Yii::t('frontend', 'Phone') ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" value="<?=Yii::$app->getUser()->identity->email?>" required="required"
                                               name="User[email]"
                                               placeholder="<?= Yii::t('frontend', 'E-mail') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class="text-muted"><?= Yii::t('frontend', 'Order notice') ?></p>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-success center-block"><?= FA::i('check') . ' ' . Yii::t('frontend', 'Order') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="<?= $this->renderDynamic('return Yii::$app->request->csrfParam;'); ?>"
                       value="<?= $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>"/>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="">
        <h4 class="text-muted "><?= Yii::t('frontend', 'Shopping Cart Empty') ?></h4>
    </div>
<?php } ?>
<?php $this->registerJs('
    $(function () {
        $(\'[data-toggle="tooltip"]\').tooltip();
    });
'); ?>