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











    <div class="content-body">
                <!-- eCommerce statistic -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['lineup/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info"><?=($products)? $products: 0?></h3>
                                                <h6>Всего обслуженно  машин</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('car')->size('3x')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['clients/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="warning"><?=($users)? $users: 0?></h3>
                                                <h6>Всего клиентов</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('user')->size('3x')->addCssClass('warning icon-user-follow orange font-large-2 float-right')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['profit/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="success"><?=($profit)? number_format($profit,0, '', ' '): 0?></h3>
                                                <h6>Приход за все время</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('arrow-down')->size('3x')->addCssClass('success font-large-2 float-right')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['expenses/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="danger"><?=($expenses)? number_format($expenses, 0, '', ' '): 0?></h3>
                                                <h6>Расходов за все время</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('arrow-up')->size('3x')->addCssClass(' danger font-large-2 float-right')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['lineup/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info"> <?=($products_today)? $products_today: 0?></h3>
                                                <h6>Машин добавленно сегодня</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('car')->size('3x')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['clients/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="warning"><?=($users_today)? $users_today: 0?></h3>
                                                <h6>Клиентов добавлено сегодня</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('user')->size('3x')->addCssClass('warning icon-user-follow orange font-large-2 float-right')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['profit/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="success"><?=($profit_today)? number_format($profit_today,0, '', ' '): 0?></h3>
                                                <h6>Приход за сегодня</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('arrow-down')->size('3x')->addCssClass('success font-large-2 float-right')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <a href="<?=Url::to(['expenses/index', 'sort' => '-id'])?>">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="danger"> <?=($expenses_today)?  number_format($expenses_today, 0, '', ' '): 0?></h3>
                                                <h6>Расходов за сегодня</h6>
                                            </div>
                                            <div>
                                                <?=FA::i('arrow-up')->size('3x')->addCssClass(' danger font-large-2 float-right')?>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



        <div class="row">
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <a href="<?=Url::to(['lineup/index', 'sort' => '-id'])?>">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="info"> <?=($products_active)? $products_active: 0?></h3>
                                        <h6>Активных Машин</h6>
                                    </div>
                                    <div>
                                        <?=FA::i('car')->size('3x')?>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <a href="<?=Url::to(['clients/index', 'sort' => '-id'])?>">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="warning"><?=($users_active)? $users_active: 0?></h3>
                                        <h6>Активных Клиентов</h6>
                                    </div>
                                    <div>
                                        <?=FA::i('user')->size('3x')->addCssClass('warning icon-user-follow orange font-large-2 float-right')?>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <a href="<?=Url::to(['profit/index', 'sort' => '-id'])?>">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="success"><?=($profit_active)? number_format($profit_active,0, '', ' '): 0?></h3>
                                        <h6>Активных доходов</h6>
                                    </div>
                                    <div>
                                        <?=FA::i('arrow-down')->size('3x')->addCssClass('success font-large-2 float-right')?>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <a href="<?=Url::to(['expenses/index', 'sort' => '-id'])?>">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="danger"> <?=($profit_active)?  number_format($profit_active, 0, '', ' '): 0?></h3>
                                        <h6>Активных Расходов</h6>
                                    </div>
                                    <div>
                                        <?=FA::i('arrow-up')->size('3x')->addCssClass(' danger font-large-2 float-right')?>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>



                <!--/ eCommerce statistic -->

                <!-- Products sell and New Orders -->

                <div class="row match-height">
                    <div class="col-xl-8 col-12" id="ecommerceChartView">
                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20">
                                <div class="btn-group dropdown">
                                    <a href="#" class="text-body dropdown-toggle blue-grey-700" data-toggle="dropdown">PRODUCTS SALES</a>
                                    <div class="dropdown-menu animate" role="menu">
                                        <a class="dropdown-item" href="#" role="menuitem">Sales</a>
                                        <a class="dropdown-item" href="#" role="menuitem">Total sales</a>
                                        <a class="dropdown-item" href="#" role="menuitem">profit</a>
                                    </div>
                                </div>
                                <ul class="nav nav-pills nav-pills-rounded chart-action float-right btn-group" role="group">
                                    <li class="nav-item"><a class="active nav-link" data-toggle="tab" href="#scoreLineToDay">Day</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToWeek">Week</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToMonth">Month</a></li>
                                </ul>
                            </div>
                            <div class="widget-content tab-content bg-white p-20">
                                <div class="ct-chart tab-pane active scoreLineShadow" id="scoreLineToDay"></div>
                                <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToWeek"></div>
                                <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToMonth"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Новые клиенты</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div id="new-orders" class="media-list position-relative">
                                    <div class="table-responsive">
                                        <table id="new-orders-table" class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">FIO</th>
                                                    <th class="border-top-0">Photo</th>
                                                    <th class="border-top-0">Статус</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach ($clients as $client) { ?>
                                                <tr>
                                                    <td class="text-truncate"> <?=$client->FIO?> </td>
                                                    <td class="text-truncate p-1">
                                                        <ul class="list-unstyled users-list m-0">
<!--                                                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">-->
<!--                                                                <img class="media-object rounded-circle" src="backend/web/app-assets/images/portrait/small/avatar-s-19.png" alt="Avatar">-->
<!--                                                            </li>-->
<!--                                                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">-->
<!--                                                                <img class="media-object rounded-circle" src="backend/web/app-assets/images/portrait/small/avatar-s-18.png" alt="Avatar">-->
<!--                                                            </li>-->
<!--                                                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Joseph Weaver" class="avatar avatar-sm pull-up">-->
<!--                                                                <img class="media-object rounded-circle" src="backend/web/app-assets/images/portrait/small/avatar-s-17.png" alt="Avatar">-->
<!--                                                            </li>-->

                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <?php $prodstatusFormat = [
                                                            '0' => '<span class="text-warning">'.FA::i('info').' Не активен'.'</span>',
                                                            '-1' => '<span class="text-danger">'.FA::i('remove').' Заблокирован'.'</span>',
                                                            '1' => '<span class="text-success">'.FA::i('check').' Активен'.'</span>'
                                                        ];?>
                                                        <?=$prodstatusFormat[$client->status]?>
                                                    </td>
                                                    <td><a href="<?=Url::to(['clients/update', 'id' => $client->id])?>"><?=FA::i('arrow-right')->addCssClass('text-secondary')?></a></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Products sell and New Orders -->

                <!-- Recent Transactions -->
                <div class="row">
                    <div id="recent-transactions" class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Новые авто</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
<!--                                    <ul class="list-inline mb-0">-->
<!--                                        <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="invoice-summary.html" target="_blank">Invoice Summary</a></li>-->
<!--                                    </ul>-->
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="recent-orders" class="table table-hover table-xl mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">ID</th>
                                                <th class="border-top-0">Название</th>
                                                <th class="border-top-0">Владелец авто</th>
                                                <th class="border-top-0">Фото машины</th>
                                                <th class="border-top-0">Пробег</th>
                                                <th class="border-top-0">Гос. Номер</th>
                                                <th class="border-top-0">Цена авто</th>
                                                <th class="border-top-0">Добавлено</th>
                                                <th class="border-top-0">Статус</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($shops as $shop) { ?>
                                            <tr>
                                                <td class="text-truncate"><i class="la la-dot-circle-o success font-medium-1 mr-1"></i> <?=$shop->id?></td>
                                                <td class="text-truncate"><?=$shop->translate->name?></td>
                                                <td class="text-truncate"><a href="<?=Url::to(['clients/update', 'id' => $shop->clients->id])?>"><?=$shop->clients->FIO?></a></td>
                                                <td class="text-truncate">
                                                    <span class="avatar avatar-xs">
                                                        <img class="box-shadow-2" src="" alt="avatar">
                                                    </span>
                                                    <span>Photo</span>
                                                </td>
                                                <td class="text-truncate p-1">
                                                     <?=$shop->mileage?>
                                                </td>
                                                <td><?=($shop->auto_number)?></td>
                                                <td><?=FA::i('many')->size('3x')?><?=$shop->price?></td>
                                                <td><?=date('d.m.Y', $shop->created_at)?></td>
                                                <td>
                                                    <?php $ahopstatusFormat = [
                                                        '0' => '<span class="text-danger">'.FA::i('remove').' Заблокирован'.'</span>',
                                                        '1' => '<span class="text-success">'.FA::i('check').' Активен'.'</span>'
                                                    ];?>
                                                    <?=$ahopstatusFormat[$shop->status]?>
                                                </td>
                                                <td><a href="<?=Url::to(['lineup/update', 'id' => $shop->id, 'category' => $shop->brand->category_id])?>"><?=FA::i('arrow-right')->size('2x')->addCssClass('text-primary')?></a></td>

                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Recent Transactions -->

                <!--Recent Orders & Monthly Sales -->
<!--                <div class="row match-height">-->
<!--                    <div class="col-xl-8 col-lg-12">-->
<!--                        <div class="card">-->
<!--                            <div class="card-content ">-->
<!--                                <div id="cost-revenue" class="height-250 position-relative"></div>-->
<!--                            </div>-->
<!--                            <div class="card-footer">-->
<!--                                <div class="row mt-1">-->
<!--                                    <div class="col-3 text-center">-->
<!--                                        <h6 class="text-muted">Total Products</h6>-->
<!--                                        <h2 class="block font-weight-normal">18.6 k</h2>-->
<!--                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">-->
<!--                                            <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-3 text-center">-->
<!--                                        <h6 class="text-muted">Total Sales</h6>-->
<!--                                        <h2 class="block font-weight-normal">64.54 M</h2>-->
<!--                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">-->
<!--                                            <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-3 text-center">-->
<!--                                        <h6 class="text-muted">Total Cost</h6>-->
<!--                                        <h2 class="block font-weight-normal">24.38 B</h2>-->
<!--                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">-->
<!--                                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-3 text-center">-->
<!--                                        <h6 class="text-muted">Total Revenue</h6>-->
<!--                                        <h2 class="block font-weight-normal">36.72 M</h2>-->
<!--                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">-->
<!--                                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-xl-4 col-lg-12">-->
<!--                        <div class="card">-->
<!--                            <div class="card-content">-->
<!--                                <div class="card-body sales-growth-chart">-->
<!--                                    <div id="monthly-sales" class="height-250"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="card-footer">-->
<!--                                <div class="chart-title mb-1 text-center">-->
<!--                                    <h6>Total monthly Sales.</h6>-->
<!--                                </div>-->
<!--                                <div class="chart-stats text-center">-->
<!--                                    <a href="#" class="btn btn-sm btn-danger box-shadow-2 mr-1">Statistics <i class="ft-bar-chart"></i></a> <span class="text-muted">for the last year.</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!--/Recent Orders & Monthly Sales -->

                <!-- Basic Horizontal Timeline -->
                <!--
                <div class="row match-height">
                    <div class="col-xl-4 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Basic Card</h4>
                            </div>
                            <div class="card-content">
                                <img class="img-fluid" src="backend/web/app-assets/images/carousel/05.jpg" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            <div class="card-footer border-top-blue-grey border-top-lighten-5 text-muted">
                                <span class="float-left">3 hours ago</span>
                                <span class="float-right">
                                    <a href="#" class="card-link">Read More <i class="fa fa-angle-right"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Horizontal Timeline</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-text">
                                        <section class="cd-horizontal-timeline">
                                            <div class="timeline">
                                                <div class="events-wrapper">
                                                    <div class="events">
                                                        <ol>
                                                            <li><a href="#0" data-date="16/01/2015" class="selected">16 Jan</a></li>
                                                            <li><a href="#0" data-date="28/02/2015">28 Feb</a></li>
                                                            <li><a href="#0" data-date="20/04/2015">20 Mar</a></li>
                                                            <li><a href="#0" data-date="20/05/2015">20 May</a></li>
                                                            <li><a href="#0" data-date="09/07/2015">09 Jul</a></li>
                                                            <li><a href="#0" data-date="30/08/2015">30 Aug</a></li>
                                                            <li><a href="#0" data-date="15/09/2015">15 Sep</a></li>
                                                        </ol>
                                                        <span class="filling-line" aria-hidden="true"></span>
                                                    </div>

                                                </div>

                                                <ul class="cd-timeline-navigation">
                                                    <li><a href="#0" class="prev inactive">Prev</a></li>
                                                    <li><a href="#0" class="next">Next</a></li>
                                                </ul>

                                            </div>

                                            <div class="events-content">
                                                <ol>
                                                    <li class="selected" data-date="16/01/2015">
                                                        <blockquote class="blockquote border-0">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object img-xl mr-1" src="backend/web/app-assets/images/portrait/small/avatar-s-5.png" alt="Generic placeholder image">
                                                                </div>
                                                                <div class="media-body">
                                                                    Sometimes life is going to hit you in the head with a brick. Don't lose faith.
                                                                </div>
                                                            </div>
                                                            <footer class="blockquote-footer text-right">Steve Jobs
                                                                <cite title="Source Title">Entrepreneur</cite>
                                                            </footer>
                                                        </blockquote>
                                                        <p class="lead mt-2">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at.
                                                        </p>
                                                    </li>
                                                    <li data-date="28/02/2015">
                                                        <blockquote class="blockquote border-0">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object img-xl mr-1" src="backend/web/app-assets/images/portrait/small/avatar-s-6.png" alt="Generic placeholder image">
                                                                </div>
                                                                <div class="media-body">
                                                                    Sometimes life is going to hit you in the head with a brick. Don't lose faith.
                                                                </div>
                                                            </div>
                                                            <footer class="blockquote-footer text-right">Steve Jobs
                                                                <cite title="Source Title">Entrepreneur</cite>
                                                            </footer>
                                                        </blockquote>
                                                        <p class="lead mt-2">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at.
                                                        </p>
                                                    </li>
                                                    <li data-date="20/04/2015">
                                                        <blockquote class="blockquote border-0">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object img-xl mr-1" src="backend/web/app-assets/images/portrait/small/avatar-s-7.png" alt="Generic placeholder image">
                                                                </div>
                                                                <div class="media-body">
                                                                    Sometimes life is going to hit you in the head with a brick. Don't lose faith.
                                                                </div>
                                                            </div>
                                                            <footer class="blockquote-footer text-right">Steve Jobs
                                                                <cite title="Source Title">Entrepreneur</cite>
                                                            </footer>
                                                        </blockquote>
                                                        <p class="lead mt-2">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at.
                                                        </p>
                                                    </li>
                                                    <li data-date="20/05/2015">
                                                        <blockquote class="blockquote border-0">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object img-xl mr-1" src="backend/web/app-assets/images/portrait/small/avatar-s-8.png" alt="Generic placeholder image">
                                                                </div>
                                                                <div class="media-body">
                                                                    Sometimes life is going to hit you in the head with a brick. Don't lose faith.
                                                                </div>
                                                            </div>
                                                            <footer class="blockquote-footer text-right">Steve Jobs
                                                                <cite title="Source Title">Entrepreneur</cite>
                                                            </footer>
                                                        </blockquote>
                                                        <p class="lead mt-2">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at.
                                                        </p>
                                                    </li>
                                                    <li data-date="09/07/2015">
                                                        <blockquote class="blockquote border-0">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object img-xl mr-1" src="backend/web/app-assets/images/portrait/small/avatar-s-9.png" alt="Generic placeholder image">
                                                                </div>
                                                                <div class="media-body">
                                                                    Sometimes life is going to hit you in the head with a brick. Don't lose faith.
                                                                </div>
                                                            </div>
                                                            <footer class="blockquote-footer text-right">Steve Jobs
                                                                <cite title="Source Title">Entrepreneur</cite>
                                                            </footer>
                                                        </blockquote>
                                                        <p class="lead mt-2">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at.
                                                        </p>
                                                    </li>
                                                    <li data-date="30/08/2015">
                                                        <blockquote class="blockquote border-0">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object img-xl mr-1" src="backend/web/app-assets/images/portrait/small/avatar-s-6.png" alt="Generic placeholder image">
                                                                </div>
                                                                <div class="media-body">
                                                                    Sometimes life is going to hit you in the head with a brick. Don't lose faith.
                                                                </div>
                                                            </div>
                                                            <footer class="blockquote-footer text-right">Steve Jobs
                                                                <cite title="Source Title">Entrepreneur</cite>
                                                            </footer>
                                                        </blockquote>
                                                        <p class="lead mt-2">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at.
                                                        </p>
                                                    </li>
                                                    <li data-date="15/09/2015">
                                                        <blockquote class="blockquote border-0">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object img-xl mr-1" src="backend/web/app-assets/images/portrait/small/avatar-s-7.png" alt="Generic placeholder image">
                                                                </div>
                                                                <div class="media-body">
                                                                    Sometimes life is going to hit you in the head with a brick. Don't lose faith.
                                                                </div>
                                                            </div>
                                                            <footer class="blockquote-footer text-right">Steve Jobs
                                                                <cite title="Source Title">Entrepreneur</cite>
                                                            </footer>
                                                        </blockquote>
                                                        <p class="lead mt-2">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at.
                                                        </p>
                                                    </li>
                                                </ol>
                                            </div>

                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <!--/ Basic Horizontal Timeline -->
            </div>



