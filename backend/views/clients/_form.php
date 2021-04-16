<?php


use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use common\models\Staff;
use common\models\Clients;

use  yii\jui\DatePicker;


/* @var $this yii\web\View */
/* @var $model backend\models\Clients */
/* @var $form yii\widgets\ActiveForm */
// $all_staff = Staff::find()->where(['status' => 1, 'id' => $model->staff_id])->all();


$clients = Clients::find()->all();


$all_staff = Staff::find()->where(['status' => '1'])->all();


// debug($all_staff);
$staffs = [];
if (!empty($all_staff)) {
    foreach ($all_staff as $staff) {
        $staffs[$staff->id] = $staff->FIO;
    }
}
?>

<div class="clients-form">


<?php $form = ActiveForm::begin(); ?>
    <div div class="row">   
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'staff_id')->dropDownList($staffs, ['options'=>[8=>['Selected'=>true]]]) ?>
        </div>

        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'is_seller')->dropDownList(["1" => "Продовец", "0" => "Покупатель"]) ?>

        </div>

    </div>

    <div div class="row">   
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'FIO')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div div class="row">   
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'pasport_serial')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6 col-md-6">
            <?= $form->field($model,'brithsday')->widget(DatePicker::className(),
            [
                'dateFormat' => 'yyyy-MM-dd'
            ]) 
            ?>
        </div>
    </div>

    
    <div div class="row">   
        <div class="col-sm-6 col-md-6">
            <?= $form->field($model, 'registration')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6 col-md-6">    
            <?= $form->field($model, 'status')->dropDownList(["1" => "Активен", "0" => "Не активен"]) ?>
        </div>
    </div>


    <div class="form-group  text-right">
        <a href="<?= Url::to(['clients/index']) ?>" class="btn btn-secondary btn-cancel">Назад</a>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    

    <?php ActiveForm::end(); ?>

</div>
