<?php
use common\models\Category;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;

/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */

if(!function_exists('recursiveLeftCatMenu')) {
function recursiveLeftCatMenu($menu, $parent = 0)
{
    $active_ids = ['0' => ''];
    $root_cat = Category::findOne(Yii::$app->session->get('active_category'));

    while ($root_cat) {
        $active_ids[] = $root_cat->id;
        if (empty($root_cat->parent)) break;
        $root_cat = $root_cat->parent;
    }
    $active_ids = array_reverse($active_ids);
    $result = '<ul class="list-unstyled lcm-root-cat  lcm-root-cat-scroll">';
    $class = '';
    $link = 'lcm-subLink';
    if ($parent == 0) {
        $result .= '<li class="lcm-menu-title text-secondary"><strong>' . Yii::t('frontend', 'Product catalogue')
            . '</strong>' . FA::i('folder-open')->addCssClass('pull-right text-muted') . '
        </li>';
        $class = 'lcm-title';
        $link = 'lcm-link';
    }
    for ($s = 0; $s < count($menu); $s++) {
        $fa = '';
        $img = $menu[$s]->icon? '<img src="'.$menu[$s]->icon.'" alt="'.$s.'" class="cat_icon"> ': '';
        $title = $menu[$s]->translate->name;
        if ($menu[$s]->activeCategories) {
            if ($active_ids[$parent] == $menu[$s]->id) $fa = FA::i('angle-right')->addCssClass('pull-right');
            else $fa = FA::i('angle-right')->addCssClass('pull-right');
        }
        if ($active_ids[$parent] == $menu[$s]->id) {
            $title = '<strong>' . $title . '</strong>';
        }
        $childrens = '';
        if($menu[$s]->activeCategories != null) {
            $childrens = getMenuChild($menu[$s]->activeCategories);
        }
        $result .= $childrens;
        $result .= '</li>';
    }

    $result .= '</ul>';
    return $result;
}
}
if(!function_exists('getMenuChild')) {
function getMenuChild($child, $index = 0) {
    if($index == 0) $result = '<ul class="dropdown list-unstyled lcm-title ">';
    else $result = '<ul class="dropdown-menu dropdown-menu-leftmenu ">';
    foreach ($child as $item) {
        $fa = '';
        $childrens = '';
        if($item->activeCategories != null) {
            $fa = '<i class="fa fa-angle-right" style="display: table-cell;vertical-align: middle;padding-left: 0.5em;"></i>';
            $childrens = getMenuChild($item->activeCategories, $index + 1);
        }
        $img = $item->icon? '<img src="'.$item->icon.'" alt="" class="cat_icon"> ': '';
        $title = /*$img.*/'<span style="display: table-cell;vertical-align: middle;width: 95%;">'.$item->translate->name.'</span>';
        $result .= '<li class="dropdown lcm-title">
            <a href="'.Url::to(['category/index', 'id' => $item->url]).'" class="lcm-link" id="dLabel" data-target="#"  role="button" aria-haspopup="true" aria-expanded="false">
                '.$title.$fa.' 
            </a>
            '.$childrens.'
        </li>';
    }
    $result .= '</ul>';
    return $result;
}
}

?>

<?php if(!empty($menu)) {

    $active_top_cat = (!empty(Yii::$app->session->get('active_category')))? Yii::$app->session->get('active_category'): 0;
    ?>
<div class="tab-content">
    <?php for($lcm = 0; $lcm < count($menu); $lcm++) {
        if($active_top_cat == 0) $active_top_cat = $menu[0]->id; ?>
    <div role="tabpanel" class="tab-pane <?=($active_top_cat == $menu[$lcm]->id)? 'active tab-pane-first': ''?>" id="tab-menu<?=($lcm + 1 + $tab)?>">
        <div id="left-category-menu">
            <div class="navbar-header">
            </div>
            <div class=" navbar-collapse" style="padding: 0;" id="left-menu<?=($lcm + 1)?>">
                <div class="white-block text-left">
                    <?= recursiveLeftCatMenu([$menu[$lcm]]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>
