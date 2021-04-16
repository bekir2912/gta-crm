<?php
namespace store\controllers;

use common\models\Callback;
use common\models\Category;
use common\models\Order;
use common\models\Product;
use common\models\Shop;
use common\models\ShopReview;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use store\models\LoginForm;
use store\models\PasswordResetRequestForm;
use store\models\ResetPasswordForm;
use store\models\SignupForm;

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
                'only' => ['logout', 'signup', 'index', 'get-cats'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'get-cats'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(empty($shop = Shop::findOne(['id' => Yii::$app->session->get('shop_id'), 'deleted_at' => 0]))) return $this->redirect(['shop/index']);
        $top_prods = Product::find()->where(['shop_id' => Yii::$app->session->get('shop_id')])->orderBy('`view` DESC')->limit(5)->all();
        $last_reviews = ShopReview::find()->where(['shop_id' => Yii::$app->session->get('shop_id'), 'status' => 1])->orderBy('`id` DESC')->limit(5)->all();

        return $this->render('index',[
            'shop' => $shop,
            'top_prods' => $top_prods,
            'last_reviews' => $last_reviews,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        Yii::$app->session->set('user_isAuth', 'true');

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $shop = Shop::findOne(['seller_id' => Yii::$app->user->id, 'deleted_at' => 0]);
            if($shop) {
                Yii::$app->session->set('shop_id', $shop->id);
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionChangeShop()
    {

        if(!empty($shop = Shop::findOne(['id' => Yii::$app->request->get('id'), 'seller_id' => Yii::$app->user->id, 'deleted_at' => 0])))
            Yii::$app->session->set('shop_id', $shop->id);

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        $this->layout = 'signup';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $password = mt_rand(1000, 9999);
            if ($user = $model->signup($password)) {
//                if (Yii::$app->getUser()->login($user)) {
                    $model->sendEmail($password);

                    if($model->isEmail()) {
                        Yii::$app->session->setFlash('success', Yii::t('frontend', 'Password send to your email'));
                    } else if($model->isPhone()){
                        Yii::$app->session->setFlash('success', Yii::t('frontend', 'Password send to your phone'));
                    }
                    return $this->redirect(['site/login']);
//                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {

                if($model->isEmail()) {
                    Yii::$app->session->setFlash('success', Yii::t('frontend', 'Check your email for further instructions.'));
                } else if($model->isPhone()){
                    Yii::$app->session->setFlash('success', Yii::t('frontend', 'Password send to your phone'));
                }

                return $this->redirect(['site/login']);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'There is no user with this email address.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Пароль успешно сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionGetCats() {
        $this->layout = 'empty';
        $id = !empty(Yii::$app->request->get('id'))? Yii::$app->request->get('id'): null;
        $add = !empty(Yii::$app->request->get('add'))? Yii::$app->request->get('add'): '';
        $all_cats = Category::find()->with('categories')->with('parent')->where(['parent_id' => $id, 'status' => 1])->orderBy('`order`')->all();
        return $this->render('cat-widget', [
            'all_cats' => $all_cats,
            'add' => $add
        ]);
    }
}
