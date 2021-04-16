<?php

use common\models\Shop;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel store\models\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Компании';
$sellers = Shop::find()->select('seller_id')->orderBy('seller_id')->groupBy('seller_id')->all();

$seller_filter = [];
if(!empty($sellers)) {
    foreach ($sellers as $seller) {
        $seller_filter[$seller->seller->id] = $seller->seller->name;
    }
}
?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
<div class="shop-index">
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
                'id',
                [
                    'attribute' => 'name',
                    'format' => 'html',
                    'value' => function($data) {
                        $link = '';
                        return $data->name.$link;
                    }
                ],
                [
                    'label' => 'Просмотров',
                    'attribute' => 'view'
                ],
                [
                    'label' => 'Прос-ов номера',
                    'attribute' => 'view_phone'
                ],
                [
                    'label' => 'Прос-ов объявлений',
                    'attribute' => 'view_prods'
                ],
                'rating',
                [
                    'attribute' => 'status',
                    'format' => 'published',
                    'filter' => array("0" => "На модерации", "1" => "Опубликован", '-1' => 'Заблокирован'),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete} {update}',
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
