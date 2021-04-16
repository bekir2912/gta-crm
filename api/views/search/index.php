<?php
/* @var $this yii\web\View */


use common\models\Category;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'Search') . ': ' . Yii::$app->request->get('q');

$sort = [
    'price' => [
        'label' => 'price',
        'get' => ['s' => 'p', 'sd' => (Yii::$app->request->get('d') == 'a' ? 'd' : 'a')],
    ],
    'view' => [
        'label' => 'view',
        'get' => ['s' => 'v', 'sd' => (Yii::$app->request->get('d') == 'a' ? 'd' : 'a')],
    ],
];

if (Yii::$app->request->get('s') == 'p' ||
    Yii::$app->request->get('s') == 'v' ||
    Yii::$app->request->get('s') == 'd'
) {
    if (Yii::$app->request->get('sd') == 'a') {
        $fa_sort_icon[Yii::$app->request->get('s')] = FA::i('sort-amount-asc');
    } elseif (Yii::$app->request->get('sd') == 'd') {
        $fa_sort_icon[Yii::$app->request->get('s')] = FA::i('sort-amount-desc');
    } else $fa_sort_icon[Yii::$app->request->get('s')] = FA::i('sort-amount-desc');

} else $fa_sort_icon['v'] = FA::i('sort-amount-desc');

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
<div class="container">
    <?php if(empty(Yii::$app->request->get('sale'))) { ?>
        <div class="white-block" style="margin: 0 0 20px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="news_body">
                        <?= $this->title ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php Pjax::begin() ?>
<?php if (!empty($products)) { ?>
<?php if (!empty($categories)) { ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb breadcrumb_white" style="margin: 0 0 20px">
            <?php foreach($categories as $category) {
                $temp_category = Category::findOne($category); ?>
            <li class=" <?=($temp_category->id == Yii::$app->request->get('cat'))? 'search_cat_links_active': ''?>"><a href="<?=Url::current(['cat' => $temp_category->id])?>" ><?=$temp_category->translate->name?></a></li>
            <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
<?php } ?>

    <div class="row">
        <div class="col-sm-8 col-md-9">
            <?php if (!empty($products)) { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="sorting">
                                <?= Yii::t('frontend', 'Sorting') ?>:
                                <a class="sort-link"
                                   href="<?= Url::current(['s' => 'v', 'sd' => (Yii::$app->request->get('s') == '') ? 'a' : ((Yii::$app->request->get('s') == 'v' && Yii::$app->request->get('sd') == 'd') ? 'a' : 'd')]) ?>">
                                    <?= Yii::t('frontend', 'By popularity') ?> <?= (isset($fa_sort_icon['v']) ? $fa_sort_icon['v'] : '') ?>
                                </a>
                                <a class="sort-link"
                                   href="<?= Url::current(['s' => 'p', 'sd' => ((Yii::$app->request->get('s') == 'p' && Yii::$app->request->get('sd') == 'a') ? 'd' : 'a')]) ?>">
                                    <?= Yii::t('frontend', 'By price') ?> <?= (isset($fa_sort_icon['p']) ? $fa_sort_icon['p'] : '') ?>
                                </a>
                                <a class="sort-link"
                                   href="<?= Url::current(['s' => 'd', 'sd' => ((Yii::$app->request->get('s') == 'd' && Yii::$app->request->get('sd') == 'd') ? 'a' : 'd')]) ?>">
                                    <?= Yii::t('frontend', 'By date') ?> <?= (isset($fa_sort_icon['d']) ? $fa_sort_icon['d'] : '') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <div class="row" style="margin: 0 -5px;">
                    <?php for ($i = 0; $i < count($products); $i++) { ?>
                        <div class="col-md-3 col-sm-6" style="padding: 0 5px;">
                            <?=$this->render('@frontend/views/product/cart.php', ['product' => $products[$i]])?>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <h4 class="text-muted "><?= Yii::t('frontend', 'No products') ?></h4>
            <?php } ?>
            <div class="text-center">
                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                ]); ?>
            </div>
        </div>
        <div class="col-sm-4 col-md-3">
            <?php require_once('right.php') ?>
        </div>
    </div>

<?php Pjax::end() ?>
</div>
