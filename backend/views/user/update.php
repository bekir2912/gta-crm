<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Seller */

$this->title = 'Пользователь: ' . $model->name;
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="sale-create">

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" >
                                <li role="presentation" class="active"><a href="#teb_shop">Пользователь</a></li>
                                <li role="presentation" ><a href="<?=Url::to(['announcement/index', 'ProductSearch[user_id]' => $model->id, 'sort' => '-id'])?>">Объявления</a></li>
                            </ul>
                        </div>
                    </div>

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
