<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CarExpenses */

$this->title = 'Добавить тип расхода на авто';
$this->params['breadcrumbs'][] = ['label' => 'Все расходы на авто', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-expenses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
