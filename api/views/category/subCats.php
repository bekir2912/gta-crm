<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 14.10.2017
 * Time: 2:34
 */
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $category->translate->name;

function buildBreadcrumbs($menu, $index)
{
    if (!$menu) return '';
    $breadcrumbs = '<ul class="dropdown-menu" aria-labelledby="catLvl_' . $index . '">';
    foreach ($menu as $item) {
        $breadcrumbs .= '<li><a href="' . Url::to(['category/index', 'id' => $item->url]) . '">' . $item->translate->name . '</a></li>';
    }
    return $breadcrumbs . '</ul>';
}

$loop_cat = $category->parent;
$loop = 1;
while ($loop_cat) {
    $drop_icon = '';
    $dataAttributes = '';
    $subMenu_items = '';
    $is_dropdown = '';
    if (!empty($loop_cat->activeCategories)) {
        $is_dropdown = 'class="dropdown"';
        $drop_icon = FA::i('angle-down');
        $dataAttributes = 'type="button" id="catLvl_' . $loop . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
        $subMenu_items = buildBreadcrumbs($loop_cat->activeCategories, $loop);
    }
    $breads_arr[] = '<li ' . $is_dropdown . '>
                        <a href="' . Url::to(['category/index', 'id' => $loop_cat->url]) . '" ' . $dataAttributes . '>
                        ' . $loop_cat->translate->name . ' ' . $drop_icon . $subMenu_items . '
                        </a>
                    </li>';
    $loop_cat = $loop_cat->parent;
    $loop++;
}
$root_index = count($breads_arr);
$breads_arr[] = '<li class="dropdown">
                        <a href="' . (Url::to(["category/list"])) . '" type="button" id="catLvl_' . $root_index . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ' . (FA::i('bars')->addCssClass('bread-cat-icon')) . ' <strong>' . (Yii::t('frontend', 'Catalogue')) . '</strong> ' . (FA::i('angle-down'))
    . (buildBreadcrumbs(\common\models\Category::find()->where(['status' => 1, 'parent_id' => null])->orderBy('order')->all(), $root_index)) . '
                        </a>
                    </li>';
$breads = '<div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        ' . implode(' ', array_reverse($breads_arr)) . '
                    </ul>
                </div>
            </div>';
?>
<div class="bg-primary bread-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= $breads ?>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header product-widget-header" style="padding-top: 0">
                <?=$this->title?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="margin: 0 -5px;">
                            <?php if (!empty($categories)) { ?>
                                <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                    <div class="col-md-1-5 col-sm-4">
                                        <a href="<?= Url::to(['category/index', 'id' => $categories[$i]->url]) ?>"
                                           class="product-link">
                                            <div class="product-cart widget-product-cart text-center">
                                                <div class="prod-image"><img src="<?= $categories[$i]->translate->image ?>"
                                                                             alt="<?= $categories[$i]->translate->name ?>"
                                                                             class="img-responsive center-block"></div>
                                                <p class="shell_cat_name">
                                                    <a href="<?= Url::to(['category/index', 'id' => $categories[$i]->url]) ?>"
                                                       class="text-muted">
                                                        <?= $categories[$i]->translate->name ?>
                                                    </a>
                                                </p>

                                            </div>
                                        </a>
                                    </div>

                                <?php } ?>
                            <?php } else { ?>
                                <p><?= Yii::t('frontend', 'No category') ?></p>
                            <?php } ?>
                        </div>
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
</div>