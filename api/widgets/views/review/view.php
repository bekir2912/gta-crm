<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($reviews)) {$count = 0;
    $navs = '<li data-target = "#carousel-review" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
    $items = '<div class="item ' . (($count == 0) ? 'active' : '') . '">';
    for ($i = 0; $i < count($reviews); $i++) {
        $items .= '
                    <div class="col-sm-3 col-md-3" style="padding: 0">
                    <div class="news_body">
        <a href="' . Url::to(['product/index', 'id' => $reviews[$i]->product->url]) . '"  data-pjax="0">
                    <img src="' . $reviews[$i]->product->mainImage->image . '" alt="' . $reviews[$i]->product->translate->name . '" class="img-responsive " >
                    <div class="review_block">
                    <h5>' . $reviews[$i]->order->name . '
                    <small class="pull-right text-secondary">' . FA::i('star') .' '.$reviews[$i]->comment_rate . '</small>
                    </h5>
                    <div class="separator"></div>
                    <p class=" text-secondary"><em>' . $reviews[$i]->comment . '</em></p>
                    </div>
                </a>
                </div>
                </div>';

        if ((($i + 1) % 4 == 0) && ($i + 1) != count($reviews)) {
            $count++;
            $first = 0;

            $items .= '</div>';
            if(($i + 1 != count($reviews))) {
                $items .= '<div class="item ' . (($count == 0) ? 'active' : '') . '">';
                $navs .= '<li data-target = "#carousel-review" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
            }
        }
    }
    $items .= '</div>';
    ?>
    <div class="row" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="page-header" style="padding: 0 0 12px 0;">
                <h4><?=Yii::t('frontend', 'Reviews')?></h4>
            </div>
            <div class="white-block">
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-review" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner" role="listbox">
                            <?= $items ?>
                        </div>

                    <?php if(count($reviews) > 4) { ?>
                        <a class="left carousel-control" href="#carousel-review" role="button" data-slide="prev">
                            <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-review" role="button" data-slide="next">
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