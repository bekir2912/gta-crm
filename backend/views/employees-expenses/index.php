<?php

use yii\helpers\Html;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FA;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeesExpensesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы расходов на сотрудников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-expenses-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать тип расхода', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'contentOptions' => ['style' => 'width: 65px; max-width: 65px;'],
            ],
            'name',
            'discription',
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
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {delete} {update}{view}',
                'buttons' => [
                    'update' => function ($url, $data)  {
                        return Html::a(
                            FA::i('cog')->size('2x'),
                            $url, ['class' => 'text-primary']);
                    },
                    'view' => function ($url, $data)  {
                        return Html::a(
                            FA::i('eye')->size('2x'),
                            $url, ['class' => 'text-success']);
                    },
                    'delete' => function ($url, $data)  {
                        return Html::a(
                            FA::i('trash')->size('2x'),
                            $url, ['class' => 'text-danger',
                            'title'=>"Удалить", 'aria-label'=>"Удалить", 'data-pjax'=>"0", 'data-confirm'=>"Вы уверены, что хотите удалить этот элемент?", 'data-method'=>"post"
                        ]);
                    },
                ],
                'options' => ['style' => 'width: 100px; max-width: 100px;'],
                'contentOptions' => ['style' => 'width: 100px; max-width: 100px;'],
            ],
        ],
    ]); ?>
</div>
