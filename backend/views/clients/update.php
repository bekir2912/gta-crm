<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = 'Редактирование клиента: ' . $model->FIO;
$this->params['breadcrumbs'][] = ['label' => 'Все клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FIO, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
