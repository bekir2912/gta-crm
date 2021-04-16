<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($shops)) {$count = 0;
    $navs = '<li data-target = "#carousel-shop" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
    $items = '<div class="item ' . (($count == 0) ? 'active' : '') . '">';
    for ($i = 0; $i < count($shops); $i++) {
        $items .= '
                    <div class="col-sm-3 col-md-3" style="padding: 0">
        <a href="' . (($shops[$i]->url != '') ? Url::to(['shop/index', 'id' => $shops[$i]->url]) : '') . '"  data-pjax="0">
                    <img src="' . $shops[$i]->logo . '" alt="' . $shops[$i]->name . '" class="img-responsive shop_carousel_img">
                </a>
                </div>';

        if ((($i + 1) % 4 == 0) && ($i + 1) != count($shops)) {
            $count++;
            $first = 0;

            $items .= '</div>';
            if(($i + 1 != count($shops))) {
                $items .= '<div class="item ' . (($count == 0) ? 'active' : '') . '">';
                $navs .= '<li data-target = "#carousel-shop" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
            }
        }
    }
    $items .= '</div>';
    ?>
    <div class="row" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="page-header" style="padding: 0 0 12px 0;">
                <h4><?=Yii::t('frontend', 'Shops')?>
                    <small class="pull-right"><a href="<?=Url::to(['shop/list'])?>"><?=Yii::t('frontend', 'All shops')?></a></small>
                </h4>
                <div class="clearfix"></div>
            </div>
            <div class="white-block">
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-shop" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner" role="listbox">
                            <?= $items ?>
                        </div>
                        <?php if(count($shops) > 4) { ?>
                            <a class="left carousel-control" href="#carousel-shop" role="button" data-slide="prev">
                                <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-shop" role="button" data-slide="next">
                                <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
<?php } ?>