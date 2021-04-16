<?php

use common\models\Product;
use common\models\Sale;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel store\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объявления';

$cats = Product::find()->select('category_id')->orderBy('category_id')->groupBy('category_id')->all();
$cat_filter = [];
if(!empty($cats)) {
    foreach ($cats as $cat) {
        $row_cat = [];
        $row_cat[$cat->category->id] = $cat->category->translate->name;
        $parent = $cat->category->parent;
        while ($parent) {
            $temp = $row_cat;
            if(isset($row_cat)) unset($row_cat);
            $row_cat[$parent->translate->name] = $temp;
            $parent = $parent->parent;
        }
        $cat_filter = ArrayHelper::merge($cat_filter, $row_cat);
    }
}
$brands = \common\models\Brand::find()->where(['status' => 1])->all();

$brand_filter = [];
if(!empty($brands)) {
    foreach ($brands as $brand) {
        $brand_filter[$brand->id] = $brand->name;
    }
}

$sales_filter = [];
if(!empty($sales)) {
    foreach ($sales as $sale) {
        $sales_filter[$sale->id] = $sale->name;
    }
}
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
<div class="product-index">
    <div class="page-header" id="teb_shop">
        <?= Html::encode($this->title) ?>
        <p></p>
        <a href="<?=Url::current(['ProductSearch[is_moderated]' => '', 'sort' => '-id'])?>" class="btn btn-filter btn-<?=((Yii::$app->request->get('ProductSearch')['is_moderated'] == '1' || Yii::$app->request->get('ProductSearch')['is_moderated'] == '0')? 'info': 'secondary')?>">Все</a>
        <a href="<?=Url::current(['ProductSearch[is_moderated]' => '0'])?>" class="btn btn-filter btn-<?=((Yii::$app->request->get('ProductSearch')['is_moderated'] == '0')? 'secondary': 'info')?>">Только новые</a>
        <a href="<?=Url::current(['sort' => 'is_moderated'])?>" class="btn btn-filter btn-<?=((Yii::$app->request->get('sort') == 'is_moderated')? 'secondary': 'info')?>">Сначала новые</a>

    </div>
    <p></p>

<?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterRowOptions' => ['class' => 'filters prod-filter'],
            'columns' => [

                'id',
                [
                    'attribute' => 'name',
                    'label' => 'Название',
                    'format' => 'html',
                    'options' => ['width' => '300px'],
                    'value' => function($data) {
                        $link = '';
                        if($data->colored_offer > time()) {
                            $link .= '<br><i class="fa fa-paint-brush" style="color: #6e7bfe"></i> '.Yii::t('frontend', 'Colored offer').' '.(mb_strtolower(Yii::t('frontend', 'To'))).' '.date('d.m.Y H:i', $data->colored_offer);
                        }
                        if($data->special_offer > time()) {
                            $link .= '<br><i class="fa fa-star" style="color: #ffc720"></i> '.Yii::t('frontend', 'Special offer').' '.(mb_strtolower(Yii::t('frontend', 'To'))).' '.date('d.m.Y H:i', $data->special_offer);
                        }
                        if($data->is_moderated === 0) {
                            return '<div class="text-danger">'.$data->translate->name.'<span style="font-size: 11px;" class="text-success">'.$link.'</span>'.'</div>';
                        }
                        return $data->translate->name.'<span style="font-size: 11px;" class="text-success">'.$link.'</span>';
                    },
                ],
                'articul',
                [
                    'label' => 'Просмотры',
                    'attribute' => 'view'
                ],
                [
                    'label' => 'Прос-ов номера',
                    'attribute' => 'phone_views'
                ],
                [
                    'attribute' => 'category_id',
                    'value' => function($data) {
                        return $data->category->translate->name;
                    },
                    'options' => ['width' => '200px'],
                    'filter' => $cat_filter,
                ],
                [
                    'attribute' => 'brand_id',
                    'value' => function($data) {
                        return $data->brand->name;
                    },
                    'filter' => $brand_filter,
                ],
                [
                    'attribute' => 'price',
                    'value' => function($data) {
                        $price = $data->currency == 'uzs'? $data->price: $data->price_usd;
                        return  $price.' '.Yii::t('frontend', $data->currency);
                    }
                ],
                [
                    'attribute' => 'status',
                    'format'=> 'html',
                    'filter' => false,
                    'value' => function($data) {
                        if ($data->category->spec == 1) {
                            if($data->status == -1) {
                                return '<span class="text-danger"><i class="fa fa-remove"></i> Заблокирован</span>';
                            }
                            if($data->status == 0) {
                                return '<span class="text-warning"><i class="fa fa-info"></i> Не активен</span>';
                            }
                            if($data->status == 1) {
                                return '<span class="text-success"><i class="fa fa-check"></i> Активен</span>';
                            }
                        } else {
                            if($data->in_order == 1) {
                                return '<span class="text-success"><i class="fa fa-plus"></i> Под заказ</span>';
                            }
                            else {
                                if($data->status == -1) {
                                    return '<span class="text-danger"><i class="fa fa-remove"></i> Заблокирован</span>';
                                }
                                if($data->status == 0) {
                                    return '<span class="text-warning"><i class="fa fa-info"></i> Нет в наличии</span>';
                                }
                                if($data->status == 1) {
                                    return '<span class="text-success"><i class="fa fa-check"></i> Есть в наличии</span>';
                                }
                            }
                        }
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete} {update}',
                    'buttons' => [
                        'update' => function ($url, $data)  {
                            return Html::a(
                                FA::i('arrow-right')->size('2x'),
                                $url."&category=".$data->category_id."&brand=".$data->brand_id."&lineup=".$data->lineup_id, ['class' => 'text-secondary']);
                        },
                        'delete' => function ($url, $data)  {
                            return Html::a(
                                FA::i('remove')->size('2x'),
                                $url, ['class' => 'text-danger',
                                'title'=>"Удалить", 'aria-label'=>"Удалить", 'data-pjax'=>"0", 'data-confirm'=>"Вы уверены, что хотите удалить этот элемент?", 'data-method'=>"post"
                            ]);
                        },
                    ]
                ],

            ],
        ]); ?>
    </div>
<?php Pjax::end(); ?></div>
</div>
</div>
</div>
</div>

<?php $this->registerJs('
    $(document).ready(function() {
        $(\'select.form-control\').select2(
            {
                language: {
                  noResults: function () {
                    return "Ничего не найдено";
                  }
                }
            }
        );
    });
    $(document).on(\'ready pjax:success\', function() {
        $(\'select.form-control\').select2(
            {
                language: {
                  noResults: function () {
                    return "Ничего не найдено";
                  }
                }
            }
        );
    });
');?>