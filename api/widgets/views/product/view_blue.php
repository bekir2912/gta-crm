<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
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

if (!empty($products)) { ?>

    <div class="bg-blue">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($title) { ?>
                        <div class="page-header product-widget-header white">
                            <div class="pull-right hidden-xs">
                                <a href="<?= Url::to(['search/index', 'sale' => 'active']) ?>" class="white">
                                    <?= Yii::t('frontend', 'Show all categories') ?>
                                </a>
                            </div>
                            <div><?= $title ?></div>
                            <div class="pull-right hidden-sm hidden-md hidden-lg">
                                <a href="<?= Url::to(['search/index', 'sale' => 'active']) ?>" class="white">
                                    <?= Yii::t('frontend', 'Show all categories') ?>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <?php for ($i = 0; $i < count($products); $i++) {
                            if (empty($products[$i]->sale)) continue;
                            if (!$products[$i]->shop->status) continue;
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
                            <div class="col-md-1-5 col-sm-4">
                                <?=$this->render('@frontend/views/product/cart.php', ['product' => $products[$i]])?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>