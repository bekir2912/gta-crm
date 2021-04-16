<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 12.10.2017
 * Time: 16:34
 */
use frontend\widgets\WProduct;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;

$this->registerJsFile('/inputmask/jquery.inputmask.bundle.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/inputmask/inputmask/bindings/inputmask.binding.min.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = Yii::t('frontend', 'Cabinet');
$cities = \common\models\City::find()->where(['status' => 1])->orderBy('`order` ASC')->all();
?>

<section class="lk-setting">

    <?= Alert::widget() ?>
        <div class="row">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'lk-setting__form']]); ?>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                            <div class="lk-setting__photo" id="file">
                                <?php if(Yii::$app->getUser()->identity->avatar) { ?>
                                    <img src="<?=Yii::$app->getUser()->identity->avatar?>" class="lk-setting__img">
                                <?php } else { ?>
                                <div>
                                    <i class="flaticon-photo-camera"></i>
                                    <p class="lk-setting__text">
                                        <?= Yii::t('frontend', 'Add photo') ?>
                                    </p>
                                </div>
                                <?php } ?>
                            </div>
                            <input type="file" class="lk-setting__file-img" name="ProfileForm[avatar]" id="image">
                    </div>
                    <div class="col-md-7 col-sm-7">
                            <h3 class="lk-setting__heading">
                                <?= Yii::$app->getUser()->identity->username ?>
                            </h3>
                            <?= $form->field($model, 'name')->textInput(['value' => Yii::$app->getUser()->identity->name ? Yii::$app->getUser()->identity->name : '', 'class' => 'lk-setting__input', 'placeholder' => Yii::t('frontend', 'Name')])->label(false) ?>
                            <?= $form->field($model, 'birthday')->textInput(['value' => Yii::$app->getUser()->identity->birthday ? Yii::$app->getUser()->identity->birthday : '', 'class' => 'lk-setting__input', 'placeholder' => Yii::t('frontend', 'Birthday'), 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd/mm/yyyy', ])->label(false) ?>
                            <select class="lk-setting__input" name="ProfileForm[city_id]">
                                <?php for ($i = 0; $i < count($cities); $i++) { ?>
                                    <option value="<?= $cities[$i]->id ?>" <?=($cities[$i]->id == Yii::$app->getUser()->identity->city_id)? 'selected': ''?>><?= $cities[$i]->translate->name ?></option>
                                <?php } ?>
                            </select>
                        <?= $form->field($model, 'ucard')->textInput(['value' => Yii::$app->getUser()->identity->ucard ? Yii::$app->getUser()->identity->ucard : '', 'class' => 'lk-setting__input', 'placeholder' => Yii::t('frontend', 'My ID Ucard')])->label(false) ?>
                        <?= $form->field($model, 'phone')->textInput(['value' => Yii::$app->getUser()->identity->phone ? Yii::$app->getUser()->identity->phone : '', 'class' => 'lk-setting__input', 'placeholder' => Yii::t('frontend', 'Phone')])->label(false) ?>
                            <button class="lk-setting__button">
                                <?= Yii::t('frontend', 'Save') ?>
                            </button>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="password-block">
                    <h3 class="lk-setting__heading">
                        <?= Yii::t('frontend', 'Password') ?>
                    </h3>
                        <?= $form->field($model, 'password')->passwordInput(['class' => 'lk-setting__input', 'placeholder' => Yii::t('frontend', 'New Password')])->label(false) ?>
                        <?= $form->field($model, 'passwordconfirm')->passwordInput(['class' => 'lk-setting__input', 'placeholder' => Yii::t('frontend', 'Confirm New Password')])->label(false) ?>
                        <button class="lk-setting__button">
                            <?= Yii::t('frontend', 'Change Password') ?>
                        </button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </section>

<?php $this->registerJs('
    $(\'#w0\').submit(function(){
      if($(\'#profileform-password\').val() !== \'\') {
        if($(\'#profileform-passwordconfirm\').val() === \'\') {
            $(\'#profileform-passwordconfirm\').parent().addClass(\'has-error\');
            return false;
        }
      }
    })
'); ?>