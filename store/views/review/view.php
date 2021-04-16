<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = 'Отзыв';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="shop-update">
                    <div class="page-header">
                        <?= $this->title ?>
                    </div>
                    <p></p>

                    <div class="row">
                        <div class="col-md-12">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'user_id',
                                        'filter' => false,
                                        'value' => function($data) {
                                            return $data->user->name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'rating',
                                        'filter' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'label' => 'Создан',
                                        'filter' => false,
                                        'value' => function($data) {
                                            return date('d.m.Y', $data->created_at);
                                        },
                                    ],
                                    'comment'
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
