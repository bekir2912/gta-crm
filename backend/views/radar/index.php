<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SocialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Радары';

$cities = \common\models\City::find()->all();

$all_cities = [];
for ($i = 0; $i < count($cities); $i++) {
    $all_cities[$cities[$i]->id] = $cities[$i]->translate->name;
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
                                    'attribute' => 'city_id',
                                    'filter' => $all_cities,
                                    'value' => function($data) {
                                        return $data->city->translate->name;
                                    },
                                ],
                                [
                                    'attribute' => 'type',
                                    'filter' => array("0" => "Скорость", "1" => "Стоп линия"),
                                    'value' => function($data) {
                                        return $data->type == 1? "Стоп линия": "Скорость";
                                    },
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => ' {delete} {update}',
                                    'buttons' => [
                                        'update' => function ($url, $data)  {
                                            return Html::a(
                                                FA::i('arrow-right')->size('2x'),
                                                $url, ['class' => 'text-secondary']);
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
