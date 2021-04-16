<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->translate->name;
?>

<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="sale-create">
                    <div class="page-header"><?= Html::encode($this->title) ?>
                        <small class="pull-right">
                            <?= Html::a('Добавить еще', ['create'], ['class' => 'btn btn-success']) ?>
                        </small>
                    </div>
                    <p></p>
    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'info' => $info,
        // 'info_uz' => $info_uz,
        // 'info_oz' => $info_oz,
        // 'info_en' => $info_en,
    ]) ?>

</div>
</div>
</div>
</div>
</div>
