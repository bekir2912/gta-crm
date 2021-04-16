<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">

    <div class="page-header" id="teb_shop">
        <?= Html::encode($this->title) ?>
        <small class="pull-right">
            <?= Html::a('Добавить '.FA::i('plus'), ['create'], ['class' => 'btn btn-success']) ?>
        </small>
    </div>
    <p></p>
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
      
            'FIO',
            'position',
            'birthday',
            'salary',
            // 'phone',
            // 'adress',
 
          

            'created_at',
            // 'images',

            [
                'attribute' => 'status',
                'format'=> 'html',
                'filter' => array("0" => "Уволен", "1" => "Активен", "2" => "В отпуске"),
                'value' => function($data) {
                        if($data->status == 0) {
                            return '<span class="text-danger"><i class="fa fa-info"></i> Уволен</span>';
                        }
                        if($data->status == 1) {
                            return '<span class="text-success"><i class="fa fa-check-circle"></i> Активен</span>';
                        }
                        if($data->status == 2) {
                            return '<span class="text-warning"><i class="fa fa-plane"></i> В отпуске</span>';
                        }
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {delete} {update}{view}',
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