<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = $model->FIO;
$this->params['breadcrumbs'][] = ['label' => 'Все клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить этого сотрудника?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            'pasport_serial',
            'registration',
            'brithsday',
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
        ],
    ]) ?>

</div>
