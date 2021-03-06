<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Profit */

$this->title = 'Update Profit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Profits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
