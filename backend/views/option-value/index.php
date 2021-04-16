<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OptionValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Опции';
$cats = \common\models\OptionValue::find()->select('group_id')->orderBy('group_id')->groupBy('group_id')->all();
$cat_filter = [];
if(!empty($cats)) {
    foreach ($cats as $cat) {
        $row_cat = [];
        $row_cat[$cat->group->id] = $cat->group->translate->name;
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
                                    'attribute' => 'group_id',
                                    'format' => 'html',
                                    'value' => function($data) {
                                        return $data->group->translate->name.'<br/><small class="text-muted">'.$data->group->category->translate->name.'</small>';;
                                    },
                                    'options' => ['width' => '200px'],
                                    'filter' => $cat_filter,
                                ],
                                [
                                    'attribute' => 'name',
                                    'label' => 'Название',
                                    'value' => function($data) {
                                        return $data->translate->name;
                                    },
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

