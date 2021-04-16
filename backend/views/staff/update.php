<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Staff */

$this->title = 'Изменить Сотрудника: ' . $model->FIO;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FIO, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить Сотрудника';
?>
<div class="staff-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
