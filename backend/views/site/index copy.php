    <?php

    /* @var $this yii\web\View */

    use rmrevin\yii\fontawesome\FA;
    use yii\helpers\Url;

    $users_color = 'rgb(52, 152, 219)';
    $shops_color = 'rgb(155, 89, 182)';
    $products_color = 'rgb(39, 174, 96)';
    $expeses_color = 'rgb(201, 77, 87)';

    $this->title = Yii::$app->params['appName'];
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>



    <!-- <div class="row">
        <div class="col-md-12">
            <p><a href="<?= Url::to(['site/settings']) ?>">
                <i class="fa fa-cogs"></i> Настройки сайта
                </a></p>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-12">
            <h3>
                На текущий момент
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <a href="<?=Url::to(['lineup/index', 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$products_color?>;">
                            <?=FA::i('car')->size('3x')?>
                            <span>
                                <?=($products)? $products: 0?>
                            </span>
                            <p>Всего обслуженно  машин</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['lineup/index', 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$products_color?>;">
                            <?=FA::i('plus-square-o')->size('3x')?>
                            <span>
                                <?=($products_today)? $products_today: 0?>
                            </span>
                            <p>Машин добавленно сегодня</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['lineup/index', 'ProductSearch[status]' => 1, 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$products_color?>;">
                            <?=FA::i('check')->size('3x')?>
                            <span>
                                <?=($products_active)? $products_active: 0?>
                            </span>
                            <p>Активных машин</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <a href="<?=Url::to(['clients/index', 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$users_color?>;">
                            <?=FA::i('user')->size('3x')?>
                            <span style="font-size: 36px;vertical-align: middle">
                                <?=($users)? $users: 0?>
                            </span>
                            <p style="padding: 0;margin: 0;">Всего клиентов</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['clients/index', 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$users_color?>;">
                            <?=FA::i('plus-square-o')->size('3x')?>
                            <span>
                                <?=($users_today)? $users_today: 0?>
                            </span>
                            <p>Клиентов сегодня</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['clients/index', 'UserSearch[status]' => 10, 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$users_color?>;">
                            <?=FA::i('check')->size('3x')?>
                            <span>
                                <?=($users_active)? $users_active: 0?>
                            </span>
                            <p>Активных клиентов</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <a href="<?=Url::to(['staff/index', 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$shops_color?>;">
                            <?=FA::i('users')->size('3x')?>
                            <span>
                                <?=($all_shops)? $all_shops: 0?>
                            </span>
                            <p>Всего сотрудников</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['staff/index',  'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$shops_color?>;">
                            <?=FA::i('plus-square-o')->size('3x')?>
                            <span>
                                <?=($new_shops)? $new_shops: 0?>
                            </span>
                            <p>Нанято сегодня сотрудников</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['staff/index', 'ShopSearch[status]' => 1, 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$shops_color?>;">
                            <?=FA::i('check')->size('3x')?>
                            <span>
                                <?=($success_shops)? $success_shops: 0?>
                            </span>
                            <p>Активных сотрудников</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <a href="<?=Url::to(['staff/index', 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$expeses_color?>;">
                            <?=FA::i('many')->size('3x')?>
                            <span>
                                <?=($expenses)? number_format($expenses, 0, '', ' '): 0?>
                            </span>
                            <p>Расходов за все время</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['staff/index',  'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$expeses_color?>;">
                            <?=FA::i('plus-square-o')->size('3x')?>
                            <span>
                                <?=($expenses_today)?  number_format($expenses_today, 0, '', ' '): 0?>
                            </span>
                            <p>Расходы сегодня</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="<?=Url::to(['staff/index', 'ShopSearch[status]' => 1, 'sort' => '-id'])?>">
                        <div class="badge-block text-center text-muted" style="background: <?=$expeses_color?>;">
                            <?=FA::i('check')->size('3x')?>
                            <span>
                                <?=($expenses_active)? $expenses_active: 0?>
                            </span>
                            <p>Активных расходов</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        

            <!-- <div class="col-md-12">
                <div class="white-block">
                    <div class="news_body">
                        <h4 >
                            Просмотры категорий
                        </h4>
                        <hr>
                        <?php if(!empty($categories)) {
                            $dataSets = [];
                            ?>
                            <?php foreach ($categories as $category) {
                                $color = 'rgb('.mt_rand(0, 255).', '.mt_rand(0, 255).', '.mt_rand(0, 255).')';
                                $dataSets[] = [
                                    'label' => $category->translate->name,
                                    'backgroundColor' => $color,
                                    'borderColor' => $color,
                                    'data' => [$category->view],
                                ];
                                ?>
                            <?php } ?>
                                <canvas id="catViewPie"></canvas>
                            <script>
                                var catViewPie_ctx = document.getElementById('catViewPie');
                                catViewPie_ctx.height = 60;
                                var catViewPie = new Chart(catViewPie_ctx, {
                                    type: 'horizontalBar',
                                    data: {
                                        labels: ['Категории'],
                                        datasets: <?=json_encode($dataSets)?>
                                    },

                                    // Configuration options go here
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                barThickness: 20
                                            }]
                                        }
                                    }
                                });
                            </script>
                        <?php } else { ?>
                            <p class="text-muted">
                                Нет категорий
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div> -->
    </div>
    <p>&nbsp;</p>
    <div class="separator"></div>

    <section class="dynamic">
        <div class="row">
            <div class="col-md-12">
                <h3>
                    Статистизка за
                </h3>
            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="start" value="<?=$start?>">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="end" value="<?=$end?>">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success">Показать</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <strong style="margin-right: 15px;">Показать за</strong>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="<?=date('Y-m-d')?>">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-info">Сегодня</button>
                        </form>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="<?=date('Y-m-d', strtotime('-6 days'))?>">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-primary">Неделя</button>
                        </form>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="<?=date('Y-m-d', strtotime('-30 days'))?>">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-warning">Месяц</button>
                        </form>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="2018-10-01">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-danger">За все время</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <p>&nbsp;</p>
        <div class="separator"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-block">
                    <div class="news_body">
                        <h4 >Активность автосалона</h4>
                        <hr>
                        <?php if(!empty($all_products)) {
                            $dataSets = [];
                            ?>
                            <?php
                            $dataSets[] = [
                                'label' => 'Все объявления',
                                'backgroundColor' => $products_color,
                                'borderColor' => $products_color,
                                'data' => array_values($all_products['dates']),
                            ]
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="allProdStack"></canvas>
                                </div>
                            </div>
                            <script>
                                var allProdStack_ctx = document.getElementById('allProdStack').getContext('2d');
                                var allProdStack = new Chart(allProdStack_ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: <?=json_encode($dates)?>,
                                        datasets: <?=json_encode($dataSets)?>
                                    },

                                    // Configuration options go here
                                    options: {}
                                });
                            </script>
                        <?php } else { ?>
                            <p class="text-muted">
                                Нет активности
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

<!-- //=============================//       Расходы      //=======================// -->

        <!-- <div class="row">
            <div class="col-md-12">
                <h3>
                    Статистизка за
                </h3>
            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="start" value="<?=$start?>">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="end" value="<?=$end?>">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success">Показать</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <strong style="margin-right: 15px;">Показать за</strong>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="<?=date('Y-m-d')?>">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-info">Сегодня</button>
                        </form>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="<?=date('Y-m-d', strtotime('-6 days'))?>">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-primary">Неделя</button>
                        </form>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="<?=date('Y-m-d', strtotime('-30 days'))?>">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-warning">Месяц</button>
                        </form>
                        <form action="" method="get" style="display: inline-block;">
                            <input type="hidden" class="form-control" name="start" value="2018-10-01">
                            <input type="hidden" class="form-control" name="end" value="<?=date('Y-m-d')?>">
                            <button class="btn btn-danger">За все время</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <p>&nbsp;</p>
        <div class="separator"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-block">
                    <div class="news_body">
                        <h4 >Расходы</h4>
                        <hr>
                        <?php if(!empty($all_expenses)) {
                            $dataSets = [];
                            ?>
                            <?php/*
                            $dataSets[] = [
                                'label' => 'Все Расходы',
                                'backgroundColor' => $products_color,
                                'borderColor' => $products_color,
                                'data' => array_values($all_expenses['dates']),
                            ]*/
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="allProdStack"></canvas>
                                </div>
                            </div>
                          
                        <?php } else { ?>
                            <p class="text-muted">
                                Нет активности
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> -->


<!-- //=============================//       Расходы  end     //=======================// -->

        
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="white-block">
                    <div class="news_body">
                        <h4 >Машины  по категориям</h4>
                        <hr>
                        <?php if(!empty($products_by_cat)) {
                            $labels = [];
                            $backgrounds = [];
                            $data = [];
                            $dataSets = [];
                            ?>
                            <?php foreach ($products_by_cat as $category_id => $type) {
                                $color = 'rgb('.mt_rand(0, 255).', '.mt_rand(0, 255).', '.mt_rand(0, 255).')';
                                $labels[] = $type['category']->translate->name;
                                $backgrounds[] = $color;
                                $data[] = $type['total'];

                                $dataSets[] = [
                                    'label' => $type['category']->translate->name,
                                    'backgroundColor' => $color,
                                    'borderColor' => $color,
                                    'data' => array_values($type['dates']),
                                    'fill' => false,
                                ]
                                ?>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="catProdPie"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="catProdStack"></canvas>
                                </div>
                            </div>
                            <script>
                                var catProdPie_ctx = document.getElementById('catProdPie').getContext('2d');
                                var catProdPie = new Chart(catProdPie_ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: <?=json_encode($labels)?>,
                                        datasets: [{
                                            backgroundColor: <?=json_encode($backgrounds)?>,
                                            data: <?=json_encode($data)?>,
                                        }]
                                    },

                                    // Configuration options go here
                                    options: {}
                                });
                            </script>
                            <script>
                                var catProdStack_ctx = document.getElementById('catProdStack').getContext('2d');
                                var catProdStack = new Chart(catProdStack_ctx, {
                                    type: 'line',
                                    data: {
                                        labels: <?=json_encode($dates)?>,
                                        datasets: <?=json_encode($dataSets)?>
                                    },

                                    // Configuration options go here
                                    options: {}
                                });
                            </script>
                        <?php } else { ?>
                            <p class="text-muted">
                                Нет объявлений
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="white-block">
                    <div class="news_body">
                        <h4 >Новых регистраций</h4>
                        <hr>
                        <?php if(!empty($users_by_date)) {
                            $labels = [];
                            $backgrounds = [];
                            $data = [];
                            $dataSets = [];
                            ?>
                            <?php foreach ($users_by_date as $name => $type) {
                                $labels[] = $type['name'];
                                $backgrounds[] = ($name == 'users')? $users_color: $shops_color;
                                $data[] = $type['total'];

                                $dataSets[] = [
                                    'label' => $type['name'],
                                    'backgroundColor' => ($name == 'users')? $users_color: $shops_color,
                                    'borderColor' => ($name == 'users')? $users_color: $shops_color,
                                    'data' => array_values($type['dates']),
                                    'fill' => false,
                                ]
                                ?>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="userComPie"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="userComStack"></canvas>
                                </div>
                            </div>
                            <script>
                                var userComPie_ctx = document.getElementById('userComPie').getContext('2d');
                                var userComPie = new Chart(userComPie_ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: <?=json_encode($labels)?>,
                                        datasets: [{
                                            backgroundColor: <?=json_encode($backgrounds)?>,
                                            data: <?=json_encode($data)?>,
                                        }]
                                    },

                                    // Configuration options go here
                                    options: {}
                                });
                            </script>
                            <script>
                                var userComStack_ctx = document.getElementById('userComStack').getContext('2d');
                                var userComStack = new Chart(userComStack_ctx, {
                                    type: 'line',
                                    data: {
                                        labels: <?=json_encode($dates)?>,
                                        datasets: <?=json_encode($dataSets)?>
                                    },

                                    // Configuration options go here
                                    options: {}
                                });
                            </script>
                        <?php } else { ?>
                            <p class="text-muted">
                                Нет регистраций
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> -->
    </section>






    <div class="white-block">
        <div class="row">
            <div class="col-sm-12">
                <div class="news_body">
                    <div class="site-index">
                        <div class="page-header">
                            Последние добавленные авто
                            <small class="pull-right">
                                <a href="<?=Url::to(['lineup/index', 'sort' => '-id'])?>">Все авто</a>
                            </small>
                        </div>
                        <p></p>
                        <?php if(!empty($shops)) { ?>
                            <div class="table-responsive">
                                <table class="table table-stripped table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Юр.лицо</th>
                                        <th>Пробег</th>
                                        <th>На главной</th>
                                        <th>Цена авто</th>
                                        <th>Добавлено</th>
                                        <th>Статус</th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($shops as $shop) { ?>
                                        <tr>
                                            <td><?=$shop->id?></td>
                                            <td><?=$shop->translate->name?></td>
                                            <td><?=$shop->clients->FIO?></td>
                                            <td><?=($shop->mileage)?></td>
                                            <td><?=($shop->auto_number)?></td>
                                            <td><?=$shop->price?></td>
                                            <td><?=date('d.m.Y', $shop->created_at)?></td>

                                            <td>
                                                <?php $ahopstatusFormat = [
                                                    '0' => '<span class="text-danger">'.FA::i('remove').' Заблокирован'.'</span>',
                                                    '1' => '<span class="text-success">'.FA::i('check').' Активен'.'</span>'
                                                ];?>
                                                <?=$ahopstatusFormat[$shop->status]?>
                                            </td>
                                            <td><a href="<?=Url::to(['lineup/update', 'id' => $shop->id, 'category' => $shop->brand->category_id])?>"><?=FA::i('cog')->size('2x')->addCssClass('text-primary')?></a></td>

                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        <?php } else { ?>
                            <p class="text-muted">
                                Нет компаний
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="white-block">
        <div class="row">
            <div class="col-sm-12">
                <div class="news_body">
                    <div class="site-index">
                        <div class="page-header">
                            ПОСЛЕДНИЕ ДОБАВЛЕННЫЕ объявления
                            <small class="pull-right">
                                <a href="<?=Url::to(['moderating/index', 'sort' => '-id'])?>">Все объявления</a>
                            </small>
                        </div>
                        <p></p>
                        <?php if(!empty($last_products)) { ?>
                            <div class="table-responsive">
                                <table class="table table-stripped table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Артикул</th>
                                        <th>Просмотры</th>
                                        <th>Статус</th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($last_products as $top_prod) { ?>
                                        <tr>

                                            <td><?=$top_prod->id?></td>
                                            <td><?=$top_prod->translate->name?></td>
                                            <td><?=$top_prod->articul?></td>
                                            <td><?=$top_prod->view?></td>
                                            <td>
                                                <?php $prodstatusFormat = [
                                                    '0' => '<span class="text-info">'.FA::i('info').' Не активен'.'</span>',
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
                                        <th>Компания</th>
                                        <th>Отзыв</th>
                                        <th>Рейтинг</th>
                                        <th>Создан</th>
                                        <th>Статус</th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($last_reviews as $review) { ?>
                                        <tr>
                                            <td><?=$review->user->name?></td>
                                            <td><?=$review->shop->name?></td>
                                            <td><?=nl2br($review->comment)?></td>
                                            <td><?=$review->rating?></td>
                                            <td>
                                                <?php $prodstatusFormat = [
                                                    '0' => '<span class="text-info">'.FA::i('info').' Заблокирован'.'</span>',
                                                    '1' => '<span class="text-success">'.FA::i('check').' Активен'.'</span>'
                                                ];?>
                                                <?=$prodstatusFormat[$review->status]?>
                                            </td>
                                            <td><a href="<?=Url::to(['review/update', 'id' => $review->id])?>"><?=FA::i('arrow-right')->addCssClass('text-secondary')?></a></td>
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
    </div> -->

<!-- 
    <H2 style ="text-align: center">СРОКО ТУТ БУДЕТ СТАТИСТИКА</H2> -->