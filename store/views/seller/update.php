<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Seller */

$this->title = 'Профиль';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="shop-update">

                <div class="page-header"><?= Html::encode($this->title) ?></div>
                <p></p>

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

</div>
</div>
</div>
</div>
</div>
