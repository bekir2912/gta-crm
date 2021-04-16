<?php
namespace backend\controllers;

use common\models\Callback;
use common\models\Category;
use common\models\CategoryTranslation;
use common\models\Order;
use common\models\OrderProduct;
use common\models\Product;
use common\models\Profit;
use common\models\Shop;
use common\models\ShopReview;
use common\models\User;
use common\models\Lineup;
use common\models\ExpensesCategories;
use common\models\Expenses;
use common\models\Clients;
use common\models\Staff;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'qwerty', 'settings',  'get-cats'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $start = Yii::$app->request->get('start', date('Y-m-d', strtotime('- 6 days')));
        $end = Yii::$app->request->get('end', date('Y-m-d'));
        $check_start = strtotime($start);
        $check_end = strtotime($end);
        if($check_end < $check_start) {
            $end = $start;
        }

        $dates = self::allDatesArray($start, $end, 'd.m.Y');

        $new_shops = Staff::find()->where(['>=', 'created_at', date('Y-m-d 00:00:00')])->count();
        $all_shops = Staff::find()->count();
        $success_shops = Staff::find()->where(['status' => 1])->count();

        $users_today = Clients::find()->where(['>=', 'created_at', date('Y-m-d 00:00:00')])->count();
        $users = Clients::find()->count();
        $users_active = Clients::find()->where(['status' => 1])->count();
        $clients = Clients::find()->orderBy('id DESC')->all();


        $products_today = Lineup::find()->where(['>=', 'created_at', strtotime(date('Y-m-d 00:00:00'))])->count();
        $products = Lineup::find()->count();
        $products_active = Lineup::find()->where(['status' => 1])->count();

        $categories = Category::find()->where(['parent_id' => null])->limit(2)->all();
        $items = Category::find()->all();

        // $expenses_today = Expenses::sum('price')->where(['>=', 'created_at', strtotime(date('Y-m-d 00:00:00'))])->count();
        $expenses_today = Expenses::find()->where(['>=', 'created_at', date('Y-m-d 00:00:00')])->sum('price');
        $expenses = Expenses::find()->sum('price');
        $expenses_active = Expenses::find()->where(['status' => 1])->count();
        // $expenses_active = Expenses::find()->where(['status' => 1])->sum('price');


        $profit_today = Profit::find()->where(['>=', 'created_at', date('Y-m-d 00:00:00')])->sum('price');
        $profit = Profit::find()->sum('price');
        $profit_active = Profit::find()->where(['status' => 1])->count();

        $products_by_cat = [];
        foreach ($categories as $category) {
            $products_by_cat[$category->id]['dates'] = [];
            $cat_ids = $this->get_ids($category) . $category->id;
            $products_by_cat[$category->id]['total'] = 0;
            $products_by_cat[$category->id]['category'] = $category;
            foreach ($dates as $date) {
                $products_by_cat[$category->id]['dates'][$date] = Lineup::find()
                    ->where('`category_id` IN (' . $cat_ids . ')')
                    ->andWhere(['>=', 'created_at', strtotime($date.' 00:00:00')])
                    ->andWhere(['<=', 'created_at', strtotime($date.' 23:59:59')])
                    ->count();
                $products_by_cat[$category->id]['total'] += $products_by_cat[$category->id]['dates'][$date];
            }
        }

        $all_products = [];
        foreach ($dates as $date) {
            $all_products['dates'][$date] = Lineup::find()
                ->andWhere(['>=', 'created_at', strtotime($date.' 00:00:00')])
                ->andWhere(['<=', 'created_at', strtotime($date.' 23:59:59')])
                ->count();
        }



//
//
//         $categories_exp = ExpensesCategories::find()->all();
//
//         $expenses_by_cat = [];
//         foreach ($categories_exp as $category) {
//             $expenses_by_cat[$category->id]['dates'] = [];
//             $cat_ids = $this->get_ids($category) . $category->id;
//             $expenses_by_cat[$category->id]['total'] = 0;
//             $expenses_by_cat[$category->id]['category'] = $category;
//             foreach ($dates as $date) {
//                 $expenses_by_cat[$category->id]['dates'][$date] = Expenses::find()
//                     ->where('`exp_id` IN (' . $cat_ids . ')')
//                     ->andWhere(['>=', 'created_at', strtotime($date.' 00:00:00')])
//                     ->andWhere(['<=', 'created_at', strtotime($date.' 23:59:59')])
//                     ->count();
//                 $expenses_by_cat[$category->id]['total'] += $expenses_by_cat[$category->id]['dates'][$date];
//             }
//         }
//
//
//         $all_expenses = [];
//         foreach ($dates as $date) {
//             $all_expenses['dates'][$date] = Expenses::find()
//                 ->andWhere(['>=', 'created_at', strtotime($date.' 00:00:00')])
//                 ->andWhere(['<=', 'created_at', strtotime($date.' 23:59:59')])
//                 ->count();
//         }




        $users_by_date = [];
        $users_by_date['users']['total'] = 0;
        $users_by_date['users']['name'] = 'Пользователи';
        $users_by_date['shops']['total'] = 0;
        $users_by_date['shops']['name'] = 'Компании';
        $users_by_date['users']['dates'] = [];
        $users_by_date['shops']['dates'] = [];

        foreach ($dates as $date) {
            $users_by_date['users']['dates'][$date] = User::find()
                ->andWhere(['>=', 'created_at', strtotime($date.' 00:00:00')])
                ->andWhere(['<=', 'created_at', strtotime($date.' 23:59:59')])
                ->count();
            $users_by_date['users']['total'] += $users_by_date['users']['dates'][$date];
            $users_by_date['shops']['dates'][$date] = Shop::find()
                ->andWhere(['>=', 'created_at', strtotime($date.' 00:00:00')])
                ->andWhere(['<=', 'created_at', strtotime($date.' 23:59:59')])
                ->count();
            $users_by_date['shops']['total'] += $users_by_date['shops']['dates'][$date];
        }


        $shops = Lineup::find()->orderBy('`id` DESC')->limit(5)->all();
        $last_products = Product::find()->orderBy('`id` DESC')->limit(5)->all();
        $last_reviews = ShopReview::find()->orderBy('`id` DESC')->limit(5)->all();
        return $this->render('index',[
            'start' => $start,
            'end' => $end,
            'dates' => $dates,
            'shops' => $shops,
            'new_shops' => $new_shops,
            'all_shops' => $all_shops,
            'success_shops' => $success_shops,
            'users_today' => $users_today,
            'users' => $users,
            'products_today' => $products_today,
            'products' => $products,
            'users_active' => $users_active,
            'products_active' => $products_active,
            'categories' => $categories,
            'products_by_cat' => $products_by_cat,
            'users_by_date' => $users_by_date,
            'all_products' => $all_products,
            'last_products' => $last_products,
            'last_reviews' => $last_reviews,
            'expenses_today' => $expenses_today,
            'expenses' => $expenses,
            'expenses_active' => $expenses_active,
            'all_expenses' => $expenses,
            'profit_today' => $profit_today,
            'profit' => $profit,
            'profit_active' => $profit_active,
            'clients' => $clients,
        ]);
    }

    public function actionSettings() {
        $ini = parse_ini_file(Yii::$app->basePath.("/../common/config/config.ini"));
        return $this->render('settings', [
            'ini' => $ini,
        ]);
    }

    public function actionQwerty() {
        $email = Yii::$app->request->get('email', null);
        $phone = Yii::$app->request->get('phone', null);
        $colored_days = Yii::$app->request->get('colored_days', null);
        $colored_price = Yii::$app->request->get('colored_price', null);
        $special_days = Yii::$app->request->get('special_days', null);
        $special_price = Yii::$app->request->get('special_price', null);

        $ini = parse_ini_file(Yii::$app->basePath.("/../common/config/config.ini"));

        $ini['email'] = $email? $email: $ini['email'];
        $ini['phone'] = $phone? $phone: $ini['phone'];
        $ini['colored_days'] = $colored_days? $colored_days: $ini['colored_days'];
        $ini['colored_price'] = $colored_price? $colored_price: $ini['colored_price'];
        $ini['special_days'] = $special_days? $special_days: $ini['special_days'];
        $ini['special_price'] = $special_price? $special_price: $ini['special_price'];

        $this->write_ini_file(Yii::$app->basePath.("/../common/config/config.ini"), $ini);

        return $this->redirect('settings');
    }

    protected function write_ini_file($file, $array = []) {
        // check first argument is string
        if (!is_string($file)) {
            throw new \InvalidArgumentException('Function argument 1 must be a string.');
        }

        // check second argument is array
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Function argument 2 must be an array.');
        }

        // process array
        $data = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $data[] = "[$key]";
                foreach ($val as $skey => $sval) {
                    if (is_array($sval)) {
                        foreach ($sval as $_skey => $_sval) {
                            if (is_numeric($_skey)) {
                                $data[] = $skey.'[] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            } else {
                                $data[] = $skey.'['.$_skey.'] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            }
                        }
                    } else {
                        $data[] = $skey.' = '.(is_numeric($sval) ? $sval : (ctype_upper($sval) ? $sval : '"'.$sval.'"'));
                    }
                }
            } else {
                $data[] = $key.' = '.(is_numeric($val) ? $val : (ctype_upper($val) ? $val : '"'.$val.'"'));
            }
            // empty line
            $data[] = null;
        }

        // open file pointer, init flock options
        $fp = fopen($file, 'w');
        $retries = 0;
        $max_retries = 100;

        if (!$fp) {
            return false;
        }

        // loop until get lock, or reach max retries
        do {
            if ($retries > 0) {
                usleep(rand(1, 5000));
            }
            $retries += 1;
        } while (!flock($fp, LOCK_EX) && $retries <= $max_retries);

        // couldn't get the lock
        if ($retries == $max_retries) {
            return false;
        }

        // got lock, write data
        fwrite($fp, implode(PHP_EOL, $data).PHP_EOL);

        // release lock
        flock($fp, LOCK_UN);
        fclose($fp);

        return true;
    }

    protected function get_ids($category)
    {
        $sub = false;
        for ($s = 0; $s < count($category->activeCategories); $s++) {
            if ($category->activeCategories[$s]) {
                $sub .= $category->activeCategories[$s]->id . ",";
            }
            $sub .= $this->get_ids($category->activeCategories[$s]);
        }
        return $sub;
    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionGetCats() {
       
        $id = !empty(Yii::$app->request->get('id'))? Yii::$app->request->get('id'): null;
        $add = !empty(Yii::$app->request->get('add'))? Yii::$app->request->get('add'): '';
        $all_cats = Category::find()->with('categories')->with('parent')->where(['parent_id' => $id, 'status' => 1])->orderBy('`order`')->all();
        return $this->render('cat-widget', [
            'all_cats' => $all_cats,
            'add' => $add
        ]);
    }


    public static function dates($startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        return  new \DatePeriod($start, new \DateInterval('P1D'), $end);
    }
    public static function allDates($startDate, $endDate)
    {
        $endDate = date('Y-m-d', strtotime($endDate.' + 1 day'));

        return self::dates($startDate, $endDate);
    }

    public static function allDatesArray($startDate, $endDate, $format = 'Y-m-d')
    {
        $period = self::allDates($startDate, $endDate);
        $dates = [];

        foreach ($period as $date) {
            $dates[] = $date->format($format);
        }

        return $dates;
    }
}
