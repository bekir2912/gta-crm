<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Staff */

$this->title = $model->FIO;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно желаете удалить этого сотрудника?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'FIO',
            'position',
            'birthday',
            'salary',
            'phone',
            'adress',
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
            'created_at',
            'images',
        ],
    ]) ?>

</div>
