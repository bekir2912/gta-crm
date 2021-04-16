<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CompanyExpenses */

$this->title = 'Добавить тип расхода на компанию';
$this->params['breadcrumbs'][] = ['label' => 'Все расходы на компанию', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-expenses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
