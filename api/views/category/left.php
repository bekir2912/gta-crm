<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 24.09.2017
 * Time: 3:35
 */
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;

$root_cat = $category;
$GLOBALS['cur_cat'] = $category->id;
$GLOBALS['active_ids'] = array();
while($root_cat) {
    $GLOBALS['active_ids'][] = $root_cat->id;
    if(empty($root_cat->parent)) break;
    $root_cat = $root_cat->parent;
}

function Menu($menu, $class = '')
{
    global $active_ids;
    global $cur_cat;
    $sub = '<ul class="list-unstyled '.$class.'">';
    for ($s = 0; $s < count($menu->activeCategories); $s++) {

        if(in_array($menu->activeCategories[$s]->id, $active_ids)) {
            $send_class = 'expanded';
            $fa_class = 'chevron-up';
        }
        else {
            $send_class = 'expandable';
            $fa_class = 'chevron-down';
        }
        $sub .= "<li>";
        if ($menu->activeCategories[$s]->status == 1) {
            if($cur_cat == $menu->activeCategories[$s]->id) {
                $sub .= '<strong>';
            }
            $sub .= '<a class="left-cat-link" href="'.
                Url::to(['category/index', 'id' => $menu->activeCategories[$s]->url]).'">'.
                $menu->activeCategories[$s]->translate->name .
                ($menu->activeCategories[$s]->activeCategories? FA::i($fa_class)->addCssClass('pull-right'): '').
                '</i></a>';

            if($cur_cat == $menu->activeCategories[$s]->id) {
                $sub .= '</strong>';
            }
        }
        $sub .= Menu($menu->activeCategories[$s], $send_class);
        $sub .= "</li>";
    }
    $sub .= '</ul>';
    return $sub;
}
?>
<div class="row">
    <div class="col-md-12" >
            <?=Menu($root_cat)?>
    </div>
</div>
