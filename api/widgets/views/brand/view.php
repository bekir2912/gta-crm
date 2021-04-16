<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 20.09.2017
 * Time: 4:09
 */
use yii\helpers\Url;

if (!empty($brands)) {$count = 0;
    $navs = '<li data-target = "#carousel-review" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
    $items = '<div class="item ' . (($count == 0) ? 'active' : '') . '" style="margin: 0 -5px;">';
    for ($i = 0; $i < count($brands); $i++) {
        $items .= '
                <div class="col-sm-2 col-md-2" style="padding: 0 5px;">
                    <div class="product-cart widget-product-cart text-center" style="margin-bottom: 0;">
                    <a href="' . Url::to(['brand/index', 'id' => $brands[$i]->id]) . '"  data-pjax="0">
                        <img src="' . $brands[$i]->logo . '" alt="' . $brands[$i]->name . '" class="img-responsive " >
                    
                    </a>
                    
                    </div>
                </div>';

        if ((($i + 1) % 6 == 0) && ($i + 1) != count($brands)) {
            $count++;
            $first = 0;

            $items .= '</div>';
            if(($i + 1 != count($brands))) {
                $items .= '<div class="item ' . (($count == 0) ? 'active' : '') . '">';
                $navs .= '<li data-target = "#carousel-review" data-slide-to = "' . $count . '" ' . (($count == 0) ? 'class="active"' : '') . ' ></li >';
            }
        }
    }
    $items .= '</div>';
    ?>
    <div class="row" >
        <div class="col-md-12" >
            <div class="page-header product-widget-header" style="font-weight: normal;font-family: magistral-regular, gotham-pro, Helvetica,Arial sans-serif;"><?=Yii::t('frontend', 'Brands')?></div>
            <div class="row" style="margin: 0;">
                <div class="col-md-12" style="padding: 0;">
                    <div id="carousel-review" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner" role="listbox">
                            <?= $items ?>
                        </div>

                    <?php if(count($brands) > 6) { ?>
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
<?php } ?>