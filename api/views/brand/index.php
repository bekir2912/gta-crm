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

$this->title = Yii::t('frontend', 'Brands');

?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header product-widget-header" style="padding-top: 0">
                <?=$this->title?>
            </div>
        </div>
    </div>
<?php if(empty($brands)) { ?>
    <h4 class="text-muted"><?= Yii::t('frontend', 'Empty') ?></h4>
<?php } else { ?>
    <div class="row">
    <?php foreach ($brands as $i => $brand) { ?>
        <div class="col-md-6">
            <div class="brands_card">
                <div class="row">
                    <div class="col-md-6" style="position: static;">
                        <p>
                            <strong class="brands_cat_title"><?=$brand->category->translate->name?></strong>
                        </p>
                        <a href="<?=Url::to(['category/index', 'id' => $brand->category->url, 'brands[]' => $brand->id])?>" class="brands_cat_link"><?= Yii::t('frontend', 'Show all') ?></a>
                    </div>
                    <div class="col-md-6">
                        <img src="<?=$brand->category->translate->image?>" alt="cat_name" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
        <?php if((($i + 1) % 2 == 2) && $i + 1 != count($brands)) { ?>
            </div>
            <div class="row">
        <?php } ?>
    <?php } ?>
    </div>
    <div class="col-md-12">
        <div class="text-center">
            <?php echo LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        </div>
    </div>
<?php } ?>