<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Profit */

$this->title = 'Добавить Доход';
$this->params['breadcrumbs'][] = ['label' => 'Доходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
