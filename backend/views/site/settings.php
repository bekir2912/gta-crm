<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Social */

$this->title = 'Настройки';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="sale-create">
                    <div class="page-header"><?= Html::encode($this->title) ?></div>
                    <p></p>
                    <div class="social-form">
                        <form action="<?=\yii\helpers\Url::to(['site/qwerty'])?>" method="get">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3>Услуги</h3>
                                    <div class="form-group">
                                        <label >"<?=Yii::t('frontend', 'Colored offer')?>" дни</label>
                                        <input type="number" step="1" min="1" name="colored_days" class="form-control"  value="<?=$ini['colored_days']?>">
                                    </div>
                                    <div class="form-group">
                                        <label >"<?=Yii::t('frontend', 'Colored offer')?>" цена</label>
                                        <input type="number" step="1" min="1" name="colored_price" class="form-control"  value="<?=$ini['colored_price']?>">
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label >"<?=Yii::t('frontend', 'Special offer')?>" дни</label>
                                        <input type="number" step="1" min="1" name="special_days" class="form-control"  value="<?=$ini['special_days']?>">
                                    </div>
                                    <div class="form-group">
                                        <label >"<?=Yii::t('frontend', 'Special offer')?>" цена</label>
                                        <input type="number" step="1" min="1" name="special_price" class="form-control"  value="<?=$ini['special_price']?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <h3>Обратная связь</h3>
                                    <div class="form-group">
                                        <label >Почта для связи</label>
                                        <input type="email" class="form-control" name="email" value="<?=$ini['email']?>">
                                    </div>
                                    <div class="form-group">
                                        <label >Телефон для связи</label>
                                        <input type="text" class="form-control" name="phone" value="<?=$ini['phone']?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-success">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
