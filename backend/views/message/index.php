<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Перевод сайта';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="product-index">

                    <div class="page-header">
                        <?= Html::encode($this->title) ?>
                    </div>
                    <p></p>
<?php Pjax::begin(); ?>   <div class="table-responsive"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'translation:html',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update}',
                'buttons' => [
                    'update' => function ($url, $data)  {
                        return Html::a(
                            FA::i('arrow-right')->size('2x'),
                            $url, ['class' => 'text-secondary']);
                    }
                ]
            ],
        ],
    ]); ?></div>
<?php Pjax::end(); ?></div>
            </div>
        </div>
    </div>
</div>
