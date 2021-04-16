<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CarExpenses */

$this->title = 'Изменить тип расхода: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все типы расходов на авто', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="car-expenses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
