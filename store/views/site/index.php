<?php

/* @var $this yii\web\View */

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->params['appName'];
?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                <div class="badge-block text-center text-muted">
                    <?=FA::i('eye')->size('3x')?>
                    <p>
                        <?=$shop->view?>
                    </p>
                    <small>Просмотров компании</small>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="badge-block text-center text-muted">
                    <?=FA::i('mobile-phone')->size('3x')?>
                    <p>
                        <?=$shop->view_phone?>
                    </p>
                    <small>Просмотров номера телефона</small>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="badge-block text-center text-muted">
                    <?=FA::i('car')->size('3x')?>
                    <p>
                        <?=$shop->view_prods?>
                    </p>
                    <small>Просмотров объявлений</small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="site-index">
                    <div class="page-header">
                        Топ объявления по просмотрам
                        <small class="pull-right">
                            <a href="<?=Url::to(['product/index', 'sort' => '-view'])?>">Все объявления</a>
                        </small>
                    </div>
                    <p></p>
                    <?php if(!empty($top_prods)) { ?>
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Артикул</th>
                                    <th>Просмотры</th>
                                    <th>Бренд</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($top_prods as $top_prod) { ?>
                                    <tr>

                                        <td><?=$top_prod->id?></td>
                                        <td><?=$top_prod->translate->name?></td>
                                        <td><?=$top_prod->articul?></td>
                                        <td><?=$top_prod->view?></td>
                                        <td><?=$top_prod->brand->name?></td>
                                        <td>
                                            <?php $prodstatusFormat = [
                                                '0' => '<span class="text-info">'.FA::i('info').' Нет в наличии'.'</span>',
                                                '-1' => '<span class="text-danger">'.FA::i('remove').' Заблокирован'.'</span>',
                                                '1' => '<span class="text-success">'.FA::i('check').' Активен'.'</span>'
                                            ];?>
                                            <?=$prodstatusFormat[$top_prod->status]?>
                                        </td>
                                        <td><a href="<?=Url::to(['product/update', 'id' => $top_prod->id, 'category' => $top_prod->category_id, 'brand' => $top_prod->brand_id, 'lineup' => $top_prod->lineup_id])?>"><?=FA::i('arrow-right')->addCssClass('text-secondary')?></a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p class="text-muted">
                            Нет объявлений
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="white-block">
    <div class="row">
        <div class="col-sm-12">
            <div class="news_body">
                <div class="site-index">
                    <div class="page-header">
                        ПОСЛЕДНИЕ ДОБАВЛЕННЫЕ отзывы
                        <small class="pull-right">
                            <a href="<?=Url::to(['review/index', 'sort' => '-id'])?>">Все отзывы</a>
                        </small>
                    </div>
                    <p></p>
                    <?php if(!empty($last_reviews)) { ?>
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover">
                                <tr>
                                    <th>Пользователь</th>
                                    <th>Отзыв</th>
                                    <th>Рейтинг</th>
                                    <th>Создан</th>
                                </tr>
                                <?php foreach ($last_reviews as $review) { ?>
                                    <tr>
                                        <td><?=$review->user->name?></td>
                                        <td><?=$review->shop->name?></td>
                                        <td><?=nl2br($review->comment)?></td>
                                        <td><?=$review->rating?></td>

                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p class="text-muted">
                            Нет отзывов
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>