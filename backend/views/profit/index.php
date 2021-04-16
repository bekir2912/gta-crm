<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProfitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доходы';
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="white-block">
        <div class="row">
            <div class="col-sm-12">
                <div class="news_body">
                    <div class="product-index">
                        <div class="page-header" id="teb_shop">
                            <?= Html::encode($this->title) ?>
                            <small class="pull-right">
                                <?= Html::a('Добавить '.FA::i('plus'), ['create'], ['class' => 'btn btn-success']) ?>
                            </small>
                        </div>
                        <p></p>

<?php Pjax::begin(); ?>
        <div class="table-responsive">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'discription',
            'price',
            'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        </div>
                        <?php Pjax::end(); ?></div>
                </div>
            </div>
        </div>
    </div>