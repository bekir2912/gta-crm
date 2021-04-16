<?php

use common\models\StaticPage;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\StaticPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$cats = StaticPage::find()->select('category_id')->orderBy('category_id')->groupBy('category_id')->all();

$cat_filter = [];
if(!empty($cats)) {
    foreach ($cats as $cat) {
        $cat_filter[$cat->category->id] = $cat->category->translate->name;
    }
}

$this->title = 'Страницы';
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="product-index">

                    <div class="page-header">
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

                                [
                                    'attribute' => 'category_id',
                                    'filter' => $cat_filter,
                                    'value' => function ($data) {
                                        return $data->category->translate->name;
                                    },
                                ],
                                [
                                    'label' => 'Страница',
                                    'value' => function ($data) {
                                        return $data->translate->name;
                                    },
                                ],

                                [
                                    'attribute' => 'status',
                                    'format' => 'active',
                                    'filter' => array("0" => "Не активна", "1" => "Активна"),
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => ' {delete} {update}',
                                    'buttons' => [
                                        'update' => function ($url, $data)  {
                                            return Html::a(
                                                FA::i('arrow-right')->size('2x'),
                                                $url, ['class' => 'text-secondary']);
                                        },
                                        'delete' => function ($url, $data)  {
                                            return Html::a(
                                                FA::i('remove')->size('2x'),
                                                $url, ['class' => 'text-danger',
                                                'title'=>"Удалить", 'aria-label'=>"Удалить", 'data-pjax'=>"0", 'data-confirm'=>"Вы уверены, что хотите удалить этот элемент?", 'data-method'=>"post"
                                            ]);
                                        },
                                    ]
                                ],
                            ],
                        ]); ?>
                    </div>
<?php Pjax::end(); ?></div>
            </div>
        </div>
    </div>
</div>
