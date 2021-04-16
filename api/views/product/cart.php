<?php
/**
 * Created by PhpStorm.
 * User: lexcorp
 * Date: 01.04.2018
 * Time: 18:19
 *
 *
 * @var \common\models\Product $product
 */


use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;

if (Yii::$app->user->id) {
    $userFav = \common\models\UserFavorite::find()->where(['user_id' => Yii::$app->user->id])->orderBy('`created_at` DESC')->all();
    $product_ids = array();
    if (!empty($userFav)) {
        for ($i = 0; $i < count($userFav); $i++) {
            $product_ids[] = $userFav[$i]->product_id;
        }
    }
} else {
    $product_ids = !empty(Yii::$app->session->get('product_ids')) ? Yii::$app->session->get('product_ids') : array();
}

?>
<a data-pjax='0' href="<?= Url::to(['product/index', 'id' => $product->url]) ?>" class="product-link">
    <div class="product-cart widget-product-cart">
        <div class="prod-image"><img src="<?= $product->mainImage->image ?>"
                                     alt="<?= $product->translate->name ?>"
                                     class="img-responsive center-block"></div>
            <p class="shell_prodcut_name text-primary"><?= $product->translate->name ?></p>
            <p class="shell_product_price">
                <?php
                if ($product->price_type == 0) {
                    if ($product->sale && $product->sale->value > 0) {
                        if ($product->price == 0) { ?>
                            <span class=""><?=Yii::t('frontend', 'Interesting')?></span>
                        <?php } else { ?>
                            <span class="shell_now_price"><?=$product->salePrice . ((!empty($product->unit)) ? '<small class=""> / ' . $product->unit->translate->name . '</small>' : '')?></span>
                            <br>
                            <span class="old-price text-strike text-muted"><?=$product->showPrice?></span>
                        <?php }
                    } else { ?>
                        <?php if ($product->price == 0) { ?>
                            <span class=""><?=Yii::t('frontend', 'Interesting')?></span>
                        <?php } else { ?>
                            <span class="shell_now_price"><?=$product->showPrice . ((!empty($product->unit)) ? '<small class=""> / ' . $product->unit->translate->name . '</small>' : '')?></span>
                            <br>
                            <span class="old-price"></span>
                        <?php }
                    }
                } else if ($product->price_type == 1) {
                    $ws = json_decode($product->wholesale, true);
                    if (empty($ws)) { ?>
                        <span class=""><?=Yii::t('frontend', 'Wholesale only')?></span><br>
                    <?php } else {
                        $ws_price = (preg_match('/\./i', $ws[key($ws)]))? number_format($ws[key($ws)], Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']): number_format($ws[key($ws)], Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
                        $ws_price = preg_replace('/,00$/i', '', $ws_price);
                        ?>
                        <span class="shell_now_price"><?=$ws_price.' <small>'.Yii::t('frontend', 'Currency').'</small>'.((!empty($product->unit)) ? '<small class=""> / ' . $product->unit->translate->name . '</small>' : '')?></span><br>
                        <span class="old-price  text-muted"><?=mb_strtolower(Yii::t('frontend', 'From')).' '.key($ws).((!empty($product->unit)) ? '<small class=""> ' . $product->unit->translate->name . '</small>' : '')?></span>
                    <?php }
                } else if ($product->price_type == 2) {
                    $ws = json_decode($product->wholesale, true);
                    if ($product->price == 0) {
                        if (empty($ws)) { ?>
                            <span class=""><?=Yii::t('frontend', 'Interesting')?></span><br>
                        <?php } else {
                            $ws_price = (preg_match('/\./i', $ws[key($ws)]))? number_format($ws[key($ws)], Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']): number_format($ws[key($ws)], Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
                            $ws_price = preg_replace('/,00$/i', '', $ws_price);
                            ?>
                            <span class="shell_now_price"><?=$ws_price.' <small>'.Yii::t('frontend', 'Currency').'</small>'.((!empty($product->unit)) ? '<small class=""> / ' . $product->unit->translate->name . '</small>' : '')?></span><br>
                            <span class="old-price  text-muted"><?=mb_strtolower(Yii::t('frontend', 'From')).' '.key($ws).((!empty($product->unit)) ? '<small class=""> ' . $product->unit->translate->name . '</small>' : '')?></span>
                        <?php }
                    } else {
                        if ($product->sale && $product->sale->value > 0) { ?>
                            <span class="shell_now_price"><?=$product->salePrice . ((!empty($product->unit)) ? '<small class=""> / ' . $product->unit->translate->name . '</small>' : '')?></span>
                            <span class="old-price text-strike text-muted"><?=$product->showPrice?></span><br>
                        <?php } else { ?>
                            <span class="shell_now_price"><?=$product->showPrice . ((!empty($product->unit)) ? '<small class=""> / ' . $product->unit->translate->name . '</small>' : '')?></span><br>
                            <?php if (empty($ws)) { ?>
                                <span class="old-price"></span><br>
                            <?php } else {
                                $ws_price = (preg_match('/\./i', $ws[key($ws)]))? number_format($ws[key($ws)], Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']): number_format($ws[key($ws)], Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
                                $ws_price = preg_replace('/,00$/i', '', $ws_price);?>
                                <span class="old-price text-muted"><?=$ws_price.' <small>'.Yii::t('frontend', 'Currency').'</small>'.' '.mb_strtolower(Yii::t('frontend', 'From')).' '.key($ws).((!empty($product->unit)) ? '<small class="">' . $product->unit->translate->name . '</small>' : '')?></span><br>
                            <? } ?>
                        <?php
                        }
                    }
                } ?>
            </p>
        <div class="prod-rating-block">
            <span class="rate text-secondary"><?= FA::i('star') ?></span> <?= $product->rate ?>
            <span class="rate text-primary"><i
                    class="glyphicon glyphicon-comment"></i></span> <?= $product->reviewsCount ?>
        </div>
        <?php if (in_array($product->id, $product_ids)) { ?>
            <span class="text-secondary  add_fav" data-action="remove"
                  data-prod-id="<?= $product->id ?>"><?= FA::i('paperclip')->size('2x') ?></span>
        <?php } else { ?>
            <span class="text-secondary  add_fav" data-action="add"
                  data-prod-id="<?= $product->id ?>"><?= FA::i('paperclip')->size('2x')->addCssClass('text-primary') ?></span>
        <?php } ?>
        <?php if(isset($new)) { ?>
        <?php if($new) { ?>
            <div class="new_sticker">
                <?=Yii::t('frontend', 'NEW STICKER')?>
            </div>
        <?php } ?>
        <?php } ?>
    </div>
</a>
