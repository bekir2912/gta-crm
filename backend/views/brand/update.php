<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */

$this->title = 'Марка: ' . $model->name;
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="sale-create">
                    <div class="page-header"><?= Html::encode($this->title) ?>
                        <small class="pull-right">
                            <?= Html::a('Добавить еще', ['create'], ['class' => 'btn btn-success']) ?>
                        </small></div>
                    <p></p>

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>