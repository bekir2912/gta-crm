<?php

use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SocialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';

?>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="product-index">

                    <div class="page-header">
                        <?= Html::encode($this->title) ?>

                        <a href="<?=Url::current(['ReviewSearch[is_moderated]' => '', 'sort' => '-id'])?>" class="btn btn-filter btn-<?=((Yii::$app->request->get('ReviewSearch')['is_moderated'] == '1' || Yii::$app->request->get('ReviewSearch')['is_moderated'] == '0')? 'info': 'secondary')?>">Все</a>
                        <a href="<?=Url::current(['ReviewSearch[is_moderated]' => '0'])?>" class="btn btn-filter btn-<?=((Yii::$app->request->get('ReviewSearch')['is_moderated'] == '0')? 'secondary': 'info')?>">Только новые</a>
                        <a href="<?=Url::current(['sort' => 'is_moderated'])?>" class="btn btn-filter btn-<?=((Yii::$app->request->get('sort') == 'is_moderated')? 'secondary': 'info')?>">Сначала новые</a>
                    </div>
                    <p></p>
<?php Pjax::begin(); ?>
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                [
                                    'attribute' => 'user_id',
                                    'filter' => ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'id', 'name'),
                                    'value' => function($data) {

                                        if($data->is_moderated === 0) {
                                            return '<div class="text-danger">'.$data->user->name.'</div>';
                                        }
                                        return $data->user->name;
                                    },
                                ],
                                [
                                    'attribute' => 'shop_id',
                                    'filter' => ArrayHelper::map(\common\models\Shop::find()->asArray()->all(), 'id', 'name'),
                                    'value' => function($data) {
                                        return $data->shop->name;
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
                                [
                                    'attribute' => 'status',
                                    'format'=> 'html',
                                    'filter' => ['0' => 'Заблокирован', '1' => 'Опубликован'],
                                    'value' => function($data) {
                                        if($data->status == 1) {
                                            return '<span class="text-success"><i class="fa fa-check"></i> Опубликован</span>';
                                        }
                                        return '<span class="text-warning"><i class="fa fa-info"></i> Заблокирован</span>';
                                    },
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

<?php $this->registerJs('
    $(document).on(\'ready pjax:success\', function() {
        $(\'select.form-control\').select2(
            {
                language: {
                  noResults: function () {
                    return "Ничего не найдено";
                  }
                }
            }
        );
    });
');?>
