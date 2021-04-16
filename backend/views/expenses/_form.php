<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ExpensesCategories;

/* @var $this yii\web\View */
/* @var $model common\models\Expenses */
/* @var $form yii\widgets\ActiveForm */

$all_cats = ExpensesCategories::find()->where(['status' => '1'])->all();


// debug($all_cats);
$cats = [];
if (!empty($all_cats)) {
    foreach ($all_cats as $cat) {
        $cats[$cat->id] = $cat->name;
    }
}
?>

<div class="expenses-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 ">
            <?= $form->field($model, 'exp_id')->dropDownList($cats) ?>
        </div>

        <div class="col-sm-6 ">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6 ">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>

        <div class="col-sm-6 ">
            <?= $form->field($model, 'status')->dropDownList(["1" => "Активен", "0" => "Не активен"]) ?>
        </div>

    </div>

    <div div class="row">  
        <div class="col-md-12">
            <?= $form->field($model, 'discription')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model->discription]) ?>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
