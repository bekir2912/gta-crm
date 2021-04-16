<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ExpensesCategories;


/* @var $this yii\web\View */
/* @var $model common\models\CompanyExpenses */
/* @var $form yii\widgets\ActiveForm */

// if ($model->id > 0) {
//     $cats = ExpensesCategories::find()->where(['parent_id' => null])->andWhere('`id` != ' . $model->id)->all();
// } else $cats = ExpensesCategories::find()->where(['parent_id' => null])->all();

// $cat_filter[] = 'Без родителя';
// $cat_options = [];
// if (!empty($cats)) {
//     foreach ($cats as $cat) {
//         if ($model->id == $cat->id) continue;
//         $cat_filter[$cat->id] = $cat->name;
      
//     }
// }


?>

<div class="company-expenses-form">

    <?php $form = ActiveForm::begin(); ?>


    <div div class="row">   
        <div class="col-sm-6 col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6 col-md-6">
        <?= $form->field($model, 'status')->dropDownList(["1" => "Активен", "0" => "Не активен"]) ?>
        </div>
    </div>
    <div div class="row">  
    
        <div class="col-md-12">
            <?= $form->field($model, 'discription')->textarea(['style' => 'resize: none;', 'rows' => 6, 'value' => $model->discription]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'добавить' : 'изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
