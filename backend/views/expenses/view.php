<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Expenses */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить расход?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'exp_id',
                'value' => function($data) {
                    return $data->exp->name;
                },
                'filter' => $arrexp,
            ],
            'name',
            'price',
            'discription',
            'created_at',
            'updated_at',
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
        ],
    ]) ?>

</div>
