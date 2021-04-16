<?php

namespace api\controllers;

use common\models\Banner;
use common\models\BannerTranslation;
use common\models\Category;
use common\models\Product;
use frontend\components\AuthHandler;
use common\models\Callback;
use common\models\Shop;
use common\models\StaticPage;
use common\models\StaticPageCategory;
use common\models\User;
use frontend\widgets\WProduct;
use Yii;
use yii\base\InvalidParamException;
use yii\di\Instance;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionError($message = 'Not found', $code = 404) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->getResponse()->setStatusCode($code);
        return $this->asJson(['message' => $message]);
    }
}
