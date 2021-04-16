<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */

use yii\helpers\Url;
$currency = Yii::$app->session->get('currency', 'uzs');

if (!empty($products)) { ?>

    <section class="sale-block">
        <?php if ($title) { ?>
            <h3 class="sale-block__heading">
                <?= $title ?>
            </h3>
        <?php } ?>
        <div class="owl-carousel">
    <?php for ($i = 0; $i < count($products); $i++) {
        if($currency == 'usd') {
            $products[$i]->price = $products[$i]->price_usd;
            $products[$i]->wholesale = $products[$i]->wholesale_usd;
        }
        if($products[$i]->shop_id) {
            if (!$products[$i]->shop->status) continue;
        }
        if($products[$i]->user_id) {
            if ($products[$i]->user->status != 10) continue;
        }
        $unset = false;
        $temp_parent = $products[$i]->category;
        while ($temp_parent) {
            if (!$temp_parent->status) {
                $unset = true;
                break;
            }
            if (empty($temp_parent->parent)) break;
            $temp_parent = $temp_parent->parent;
        }
        if ($unset) continue;
        ?>
            <div class="sale-block__slide">
                <a data-pjax='0' href="<?= Url::to(['product/index', 'id' => $products[$i]->url]) ?>" class="sale-block__link"></a>
                <img src="<?= $products[$i]->mainImage->image ?>" class="sale-block__img">
                <h4 class="sale-block__name">
                    <?= $products[$i]->translate->name ?>
                </h4>
                <p class="sale-block__price">
                    <?php if ($products[$i]->price_type == 0) {
                        $wholesales = json_decode($products[$i]->wholesale);
                        ?>
                        <?php if ($products[$i]->price == 0) { ?>
                            <?= Yii::t('frontend', 'Specify prices from the seller') ?>
                        <?php } else { ?>
                            <?= $products[$i]->showPrice ?>
                        <?php } ?>
                    <?php } elseif ($products[$i]->price_type == 1) {
                        $wholesales = json_decode($products[$i]->wholesale);
                        ?>
                        <?php if (!empty($wholesales)) { ?>
                            <?php foreach ($wholesales as $ws_count => $sum) {

                                $ws_price = (preg_match('/\./i', $sum)) ? number_format($sum, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']) : number_format($sum, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
                                $ws_price = preg_replace('/,00$/i', '', $ws_price);
                                ?>
                                <?= $ws_price ?> <?= Yii::t('frontend', $currency) ?>
                                <?php break; } ?>
                        <?php } else { ?>
                            <?= Yii::t('frontend', 'Specify prices from the seller') ?>
                        <?php } ?>
                    <?php } elseif ($products[$i]->price_type == 2) {
                        $wholesales = json_decode($products[$i]->wholesale);
                        ?>
                        <?php if ($products[$i]->price == 0) { ?>
                            <?php if (!empty($wholesales)) { ?>
                                <?php foreach ($wholesales as $ws_count => $sum) {
                                    $ws_price = (preg_match('/\./i', $sum)) ? number_format($sum, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']) : number_format($sum, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
                                    $ws_price = preg_replace('/,00$/i', '', $ws_price);
                                    ?>
                                    <?= $ws_price ?> <?= Yii::t('frontend', $currency) ?>
                                    <?php break; } ?>
                            <?php } else { ?>
                                <?= Yii::t('frontend', 'Specify prices from the seller') ?>
                            <?php } ?>

                        <?php } else { ?>
                            <?= $products[$i]->showPrice ?>
                        <?php } ?>
                    <?php } ?>
                </p>
            </div>
    <?php } ?>
        </div>
    </section>
<?php } ?>