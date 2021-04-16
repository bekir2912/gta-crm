<?php

use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel store\models\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';

?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
<div class="shop-index">
    <div class="page-header">
        <?= Html::encode($this->title) ?>
    </div>
    <p></p>

<?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'user_id',
                    'filter' => false,
                    'value' => function($data) {
                        return $data->user->name;
                    },
                ],
                [
                    'attribute' => 'rating',
                    'filter' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Создан',
                    'filter' => false,
                    'value' => function($data) {
                        return date('d.m.Y', $data->created_at);
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => ' {view}',
                    'buttons' => [
                        'view' => function ($url, $data)  {
                            return Html::a(
                                FA::i('eye')->size('2x'),
                                $url, ['class' => 'text-secondary']);
                        }
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
