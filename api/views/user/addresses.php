<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 12.10.2017
 * Time: 20:35
 */
use frontend\widgets\WProduct;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Addresses');
?>
<div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="white-block">
                        <div class="news_body">
                            <?php require_once('menu.php') ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="white-block">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <?= $this->title ?>
                            </div>
                        </div>
                    </div>
                        <div class="news_body">
                    <div class="address-block">
                        <?php if (!empty($addresses)) { ?>
                            <?php for ($i = 0; $i < count($addresses); $i++) { ?>
                                <div class="row" id="address_<?= $addresses[$i]->id ?>">
                                    <div class="col-sm-3">
                                        <strong id="add_name_<?= $addresses[$i]->id ?>"><?= $addresses[$i]->name ?></strong>
                                    </div>
                                    <div class="col-sm-6"
                                         id="add_address_<?= $addresses[$i]->id ?>"><?= $addresses[$i]->address ?></div>
                                    <div class="col-sm-3 text-center btn-group">
                                        <button class="btn btn-warning edit_address"
                                                data-target="<?= $addresses[$i]->id ?>"><?= FA::i('pencil') ?></button>
                                        <button class="btn btn-danger delete_address"
                                                data-target="<?= $addresses[$i]->id ?>"><?= FA::i('remove') ?></button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="separator"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="text-muted">
                                <?= Yii::t('frontend', 'No added address') ?>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="btn btn-primary"
                            id="add_add"><?= FA::i('plus') . ' ' . Yii::t('frontend', 'Add address') ?></button>
                    <div class="add_form" style="display: none;">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'id' => 'add_title']) ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <?= $form->field($model, 'address')->textarea(['placeholder' => Yii::t('frontend', 'Address placeholder'), 'id' => 'add_address']) ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?= Html::submitButton(Yii::t('frontend', 'Save'), ['class' => 'btn btn-success', 'name' => 'address']) ?>
                                <?= Html::button(Yii::t('frontend', 'Cancel'), ['class' => 'btn btn-default', 'id' => 'add_cancel', 'style' => 'border-radius: 16px;']) ?>
                            </div>
                            <?= $form->field($model, 'id')->hiddenInput(['id' => 'add_id'])->label(false) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
<?= WProduct::widget(['key' => 'recent']) ?>
</div>
