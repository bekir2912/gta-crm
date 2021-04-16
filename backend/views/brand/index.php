<?php

use common\models\Brand;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Марки';
$cats = Brand::find()->select('category_id')->orderBy('category_id')->groupBy('category_id')->all();
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
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="product-index">

                    <div class="page-header">
                        <?= Html::encode($this->title) ?>
                        <small class="pull-right">
                            <?= Html::a('Добавить '.FA::i('plus'), ['create'], ['class' => 'btn btn-success']) ?>
                        </small>
                    </div>
                    <p></p>
<?php Pjax::begin(); ?>
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                [
                                    'attribute' => 'category_id',
                                    'value' => function($data) {
                                        return $data->category->translate->name;
                                    },
                                    'options' => ['width' => '200px'],
                                    'filter' => $cat_filter,
                                ],
                                'name',
                                'on_main:boolean',
                                [
                                    'attribute' => 'status',
                                    'format' => 'active',
                                    'filter' => array("0" => "Не активна", "1" => "Активна"),
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => ' {delete} {update}',
                                    'buttons' => [
                                        'update' => function ($url, $data)  {
                                            return Html::a(
                                                FA::i('cog')->size('2x'),
                                                $url, ['class' => 'text-primary']);
                                        },
                                        'view' => function ($url, $data)  {
                                            return Html::a(
                                                FA::i('eye')->size(FA::SIZE_LARGE),
                                                $url, ['class' => 'text-success']);
                                        },
                                        'delete' => function ($url, $data)  {
                                            return Html::a(
                                                FA::i('trash')->size('2x'),
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