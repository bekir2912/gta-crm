<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */
use yii\helpers\Url;

?>

<?php if (!empty($menu)) {
    $count = 0;
    $first = 0;
    $navs = '<li data-target = "#carousel-category" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
    $items = '<div class="item ' . (($count == 0) ? 'active' : '') . '">';
    for ($i = 0; $i < count($menu); $i++) {
        $items .= '
                    <div class="col-sm-3" style="padding: 0">
        <a href="' . (($menu[$i]->url != '') ? Url::to(['category/index', 'id' => $menu[$i]->url]) : '') . '"  data-pjax="0">
                    <img src="' . $menu[$i]->translate->image . '" alt="' . $menu[$i]->translate->name . '" class="img-responsive cat_carousel_img">
                </a>
                <div class="carousel-caption carousel-category">
                    ' . (($menu[$i]->translate->name != '') ? '<p>' . $menu[$i]->translate->name . '</p>' : '') . '
                </div></div>';

        $first++;
        if ((($i + 1) % 4 == 0) && ($i + 1) != count($menu)) {
            $count++;
            $first = 0;

            $items .= '</div>';
            if(($i + 1 != count($menu))) {
                $items .= '<div class="item ' . (($count == 0) ? 'active' : '') . '">';
                $navs .= '<li data-target = "#carousel-category" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
            }
        }
    }
    $items .= '</div>';
    ?>
        <div class="white-block">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <?= Yii::t('frontend', 'Popular categories') ?>
                        <div class="pull-right"><a href="<?=Url::to(['category/list'])?>"><?=Yii::t('frontend', 'Show all categories')?></a></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-category" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner" role="listbox">
                            <?= $items ?>
                        </div>

                        <?php if(count($menu) > 4) { ?>
                        <a class="left carousel-control" href="#carousel-category" role="button" data-slide="prev">
                            <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-category" role="button" data-slide="next">
                            <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
