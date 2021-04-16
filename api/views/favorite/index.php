<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 26.09.2017
 * Time: 7:45
 */


use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$currency = Yii::$app->session->get('currency', 'uzs');

$this->title = Yii::t('frontend', 'Favorites');

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
<?php if (!empty($products)) { ?>
<section style="margin-bottom: 30px;">
    <h3 class="result-of-search__heading" style="float: none;margin: 0;padding: 0;">
        <?=$this->title?>
    </h3>

    <?php if (!empty($cats) && count($cats) > 1) { ?>
        <div class="announcements__category" style="padding: 0;
    margin: 10px 0;
    border: 0;">
            <ul class="category__list">
                <li class="category__item">
                    <a href="<?= Url::current(['cat_id' => '']) ?>" style="padding-left: 0; padding-right: 10px;"
                       class="category__link <?= (!$filter_cat) ? ' category__link--active' : '' ?>">
                        <?= Yii::t('frontend', 'All Announces') ?>
                    </a>
                </li>
                <?php foreach ($cats as $cat) { ?>
                    <li class="category__item">
                        <a href="<?= Url::current(['cat_id' => $cat->id]) ?>"
                           class="category__link <?= ($filter_cat && ($filter_cat == $cat->id)) ? ' category__link--active' : '' ?>">
                            <?= $cat->translate->name ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
        <div class="product-list clearfix">
            <?php for ($i = 0; $i < count($products); $i++) { ?>
                        <div class="product-list__item">
                            <a href="<?=Url::to(['product/index', 'id' => $products[$i]->url])?>" class="product-list__link"></a>
                            <img src="<?= $products[$i]->mainImage->image ?>" class="product-list__img">
                            <div class="product-list__block">
                                <h3 class="product-list__heading" >
                                    <?= $products[$i]->translate->name ?>
                                </h3>
                                <p class="product-list__price">
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

                                <?php if (!empty($products[$i]->activeOptions)) {
                                    $loop = 1; ?>
                                    <div class="product-list__info">
                                        <div class="row">
                                            <?php foreach ($products[$i]->activeOptions as $option) {
                                            if ($option->option->group->main == 0) continue;
                                            ?>
                                            <div class="col-md-6">
                                                <?= $option->option->translate->name ?>
                                            </div>
                                            <?php if($loop % 2 == 0) { ?>
                                        </div>
                                        <div class="row">
                                            <?php } ?>
                                            <?php $loop++; } ?>
                                        </div>
                                        <?=($products[$i]->km > 0)? number_format($products[$i]->km, 0, '', ' ').' '.Yii::t('frontend','km'):''?>
                                    </div>
                                <?php } ?>
                                <p class="product-list__time">
                                    <?php
                                        if($products[$i]->user_id) {
                                            $city_name = $products[$i]->user->city->translate->name;
                                        } else {
                                            $cities = json_decode($products[$i]->shop->cities);
                                            $city_name = '';
                                            if (!empty($cities)) {
                                                foreach ($cities as $city) {
                                                    $db_city = \common\models\City::findOne(['id' => $city, 'status' => 1]);
                                                    if($db_city) {
                                                        $city_name .= $db_city->translate->name.', ';
                                                    }
                                                }
                                                $city_name = mb_substr($city_name, 0, -2);
                                            }
                                        }
                                    ?>
                                        <?= $city_name ?>, <?= date('d.m.Y H:i', $products[$i]->created_at) ?>
                                </p>
                                <div class="product-lis__like-icon">
                                    <?php if($products[$i]->brand && $products[$i]->brand->logo != '/uploads/site/default_cat.png') { ?>
                                        <img src="<?=$products[$i]->brand->logo?>" alt="." class="brand_logo_on_product">
                                    <?php } ?>
                                    <?php if (in_array($products[$i]->id, $product_ids)) { ?>
                                        <button class="btn add_fav" style="background: #d91b30;" data-prod-id="<?=$products[$i]->id?>" data-action="remove">
                                            <i class="flaticon-like " style="color: #fff"></i>
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn add_fav" style="background: transparent;" data-prod-id="<?=$products[$i]->id?>" data-action="add">
                                            <i class="flaticon-like " ></i>
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
            <?php } ?>
        </div>
        <div class="pagination-block">
            <?php echo LinkPager::widget([
                'pagination' => $pagination,
            ]); ?>
        </div>
</section>
<?php } else { ?>
    <p class="text-center">
        <?= Yii::t('frontend', 'Nothing to show') ?>
    </p>
<?php } ?>