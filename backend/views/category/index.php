<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';

$parents = \common\models\Category::find()->select('parent_id')->orderBy('parent_id')->groupBy('parent_id')->all();

$parent_filter = [];
if(!empty($parents)) {
    foreach ($parents as $parent) {
        if($parent->parent_id != '') $parent_filter[$parent->parent->id] = $parent->parent->translate->name;
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
                                    'attribute' => 'parent_id',
                                    'filter' => $parent_filter,
                                    'value' => function ($data) {
                                        return $data->parent->translate->name;
                                    }
                                ],

                                [
                                    'label' => 'Название',
                                    'attribute' => 'name',
                                    'value' => function ($data) {
                                        return $data->translate->name;
                                    }
                                ],

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