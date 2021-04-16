<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="white-block">
<div class="row">
<div class="col-sm-12">
<div class="news_body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="page-header" id="teb_shop">
        <?= Html::encode($this->title) ?>
        <small class="pull-right">
            <?= Html::a('Добавить '.FA::i('plus'), ['create'], ['class' => 'btn btn-success']) ?>
        </small>
    </div>
    <p></p>
    <div class="table-responsive">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'contentOptions' => ['style' => 'width: 65px; max-width: 65px;'],
            ],

            [
                'attribute' => 'staff_id',
                'value' => function($data) {
                    return $data->staff->FIO;
                },
                'filter' => $arrStaff,
            ],
            // 'staff_id',
            [
                'attribute' => 'is_seller',
                'format'=> 'html',
                'filter' => array("0" => "Покупатель", "1" => "Продовец"),
                'value' => function($data) {
                        if($data->is_seller == '0') {
                            return '<span class="text-warning"><i class="fa fa-arrow-up"></i> Покупатель</span>';
                        }
                        if($data->is_seller == '1') {
                            return '<span class="text-success"><i class="fa fa-arrow-down"></i> Продовец</span>';
                        }
                },
            ],

            'FIO',
            'phone',
            // 'pasport_serial',
            // 'registration',
            // 'brithsday',
            // 'status',
            [
                'attribute' => 'status',
                'format'=> 'html',
                'filter' => array("0" => "Не активный", "1" => "Активный"),
                'value' => function($data) {
                        if($data->status == '0') {
                            return '<span class="text-danger"><i class="fa fa-info"></i> Не активный</span>';
                        }
                        if($data->status == '1') {
                            return '<span class="text-success"><i class="fa fa-check"></i> Активный</span>';
                        }
                },
            ],
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {delete} {update}{view}',
                'options' => ['style' => 'width: 80px; max-width: 80px;'],
                'contentOptions' => ['style' => 'width: 80px; max-width: 80px;'],

                'buttons' => [
                    'update' => function ($url, $data)  {
                        return Html::a(
                            FA::i('cog')->size(FA::SIZE_LARGE),
                            $url, ['class' => 'text-primary']);
                    },
                    'view' => function ($url, $data)  {
                        return Html::a(
                            FA::i('eye')->size(FA::SIZE_LARGE),
                            $url, ['class' => 'text-success']);
                    },
                    'delete' => function ($url, $data)  {
                        return Html::a(
                            FA::i('trash')->size(FA::SIZE_LARGE),
                            $url, ['class' => 'text-danger',
                            'title'=>"Удалить", 'aria-label'=>"Удалить", 'data-pjax'=>"0", 'data-confirm'=>"Вы уверены, что хотите удалить этот элемент?", 'data-method'=>"post"
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
</div>