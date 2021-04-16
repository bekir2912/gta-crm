<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 24.09.2017
 * Time: 3:35
 */
use common\models\Category;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;

$first_level_cats = Category::find()->where(['status' => 1, 'parent_id' => null])->orderBy('order')->all();
$GLOBALS['active_ids'] = array();
$GLOBALS['cur_cat'] = $cat;
for ($i = 0; $i < count($categories); $i++) {
    $temp_cat = Category::findOne($categories[$i]);
    while ($temp_cat) {
        $GLOBALS['active_ids'][] = $temp_cat->id;
        if (empty($temp_cat->parent)) break;
        $temp_cat = $temp_cat->parent;
    }
}

function shopMenu($menu, $class = '')
{
    global $active_ids;
    global $cur_cat;
    if (!in_array($menu->id, $active_ids)) return '';
    $sub = '<ul class="list-unstyled shop_cat_link ' . $class . '">';
    for ($s = 0; $s < count($menu->activeCategories); $s++) {
        if (!in_array($menu->activeCategories[$s]->id, $active_ids)) continue;
        $send_class = 'expanded';
        $fa_class = '';
        $sub .= "<li>";
        if ($menu->activeCategories[$s]->status == 1) {

            if ($cur_cat == $menu->activeCategories[$s]->id) {
                $sub .= '<strong>';
            }
            $sub .= '<a class="left-cat-link" href="' .
                Url::current(['cat' => $menu->activeCategories[$s]->id]) . '">' .
                $menu->activeCategories[$s]->translate->name .
                ($menu->activeCategories[$s]->activeCategories ? FA::i($fa_class)->addCssClass('pull-right') : '') .
                '</i></a>';

            if ($cur_cat == $menu->activeCategories[$s]->id) {
                $sub .= '</strong>';
            }
        }
        $sub .= shopMenu($menu->activeCategories[$s], $send_class);
        $sub .= "</li>";
    }
    $sub .= '</ul>';
    return $sub;
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="shop-cats">
        <?php for ($i = 0; $i < count($first_level_cats); $i++) { ?>
            <?= shopMenu($first_level_cats[$i]) ?>
        <?php } ?>

            <ul class="list-unstyled shop_cat_link">
                <li>
                    <?php if ($cat == '') { ?><strong><?php } ?>
                        <a href="<?= Url::current(['cat' => '', 'filters' => '']) ?>"
                           class="left-cat-link"><?= Yii::t('frontend', 'All products') ?></a>
                        <?php if ($cat == '') { ?></strong><?php } ?>
                </li>
            </ul>
        </div>
    </div>
</div>
