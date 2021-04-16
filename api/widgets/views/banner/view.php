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

if (!empty($banners)) {
    $navs = '';
    $items = '';
    for ($i = 0; $i < count($banners); $i++) {
        $navs .= '<li data-target = "#carousel-example-generic" data-slide-to = "' . $i . '" ' . (($i == 0) ? 'class="active"' : '') . ' ></li >';
        $items .= '<div class="item ' . (($i == 0) ? 'active' : '') . '">
                        ' . (($banners[$i]->translate->url != '') ? '<a href="'.$banners[$i]->translate->url.'"  data-pjax="0">' : '') . '
                            <img src="' . $banners[$i]->translate->image . '" alt="' . $banners[$i]->translate->name . '">
                        ' . (($banners[$i]->translate->url != '') ? '</a>' : '') . '
                        <div class="carousel-caption">
                        ' . (($banners[$i]->translate->name != '') ? '<h1>' . $banners[$i]->translate->name . '</h1>' : '') . '
                        ' . (($banners[$i]->translate->description != '') ? '<p>' . $banners[$i]->translate->description . '</p>' : '') . '
                        </div>
                    </div>';
    }
    ?>

    <div class="white-block" style="margin-bottom: 0;">
        <div class="row">
            <div class="col-md-12">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner" role="listbox">
                        <?= $items ?>
                    </div>
                    <?php if(count($banners) > 1) { ?>
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>