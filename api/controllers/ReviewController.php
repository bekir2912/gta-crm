<?php

namespace api\controllers;

use common\components\SmsService;
use common\models\Answer;
use common\models\Question;
use common\models\Shop;
use common\models\ShopReview;
use common\models\User;
use frontend\models\AnswerForm;
use frontend\models\QuestionForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;

class ReviewController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function behaviors()
    {
        $smsService = new SmsService();
        return [
            'authenticator' => [
                'class' => HttpBasicAuth::className(),
                'auth' => function ($username, $password) use ($smsService) {
                    if($smsService->isUzPhone($smsService->clearPhone($username))) {
                        $username = $smsService->clearPhone($username);
                    }
                    $user = User::findByUsername($username);
                    if (!$user) return null;
                    $check = $user->validatePassword($password);
                    return $check? $user: null;
                }
            ]
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'purchase-delete' => ['post'],
//                ],
//            ],
        ];
    }

    public function actionAdd($id)
    {
        $rating = Yii::$app->request->post('rating');
        $comment = Yii::$app->request->post('comment');

        if ($rating < 1 || $rating > 5) {
            return $this->redirect(['site/error', 'message' => 'Rating should be in range 1-5', 'code' => 422]);
        }
        if (strlen($comment) < 2) {
            return $this->redirect(['site/error', 'message' => 'Comment should contain at least 2 characters', 'code' => 422]);
        }

        $shop = Shop::find()->where(['id' => $id])->one();

        if (!$shop) {
            return $this->redirect(['site/error', 'message' => 'Service not found', 'code' => 422]);
        }
        $review = ShopReview::find()->where(['user_id' => Yii::$app->user->identity->id, 'shop_id' => $id])->one();
        if ($review) {
            return $this->redirect(['site/error', 'message' => 'User already have commented this service', 'code' => 422]);
        }
        $review = new ShopReview();
        $review->user_id = Yii::$app->user->id;
        $review->shop_id = $id;
        $review->rating = $rating;
        $review->comment = $comment;
        $review->status = 1;
        $review->save();
        $shop->rating = round(ShopReview::find()->where(['status' => 1, 'shop_id' => $id])->average("rating"), 1);
        $shop->save();

        return $this->asJson($review);
    }

    public function actionUpdate($id)
    {
        $rating = Yii::$app->request->post('rating');
        $comment = Yii::$app->request->post('comment');

        if ($rating < 1 || $rating > 5) {
            return $this->redirect(['site/error', 'message' => 'Rating should be in range 1-5', 'code' => 422]);
        }
        if (strlen($comment) < 2) {
            return $this->redirect(['site/error', 'message' => 'Comment should contain at least 2 characters', 'code' => 422]);
        }

        $shop = Shop::find()->where(['id' => $id])->one();

        if (!$shop) {
            return $this->redirect(['site/error', 'message' => 'Service not found', 'code' => 422]);
        }
        $review = ShopReview::find()->where(['user_id' => Yii::$app->user->identity->id, 'shop_id' => $id])->one();
        if (!$review) {
            return $this->redirect(['site/error', 'message' => 'Review not found', 'code' => 422]);
        }
        $review->rating = $rating;
        $review->is_moderated = 0;
        $review->comment = $comment;
        $review->save();
        $shop->rating = round(ShopReview::find()->where(['status' => 1, 'shop_id' => $id])->average("rating"), 1);
        $shop->save();

        return $this->asJson($review);
    }
    public function actionDelete($id)
    {
        $shop = Shop::find()->where(['id' => $id])->one();

        if (!$shop) {
            return $this->redirect(['site/error', 'message' => 'Service not found', 'code' => 422]);
        }
        $review = ShopReview::find()->where(['user_id' => Yii::$app->user->identity->id, 'shop_id' => $id])->one();
        if (!$review) {
            return $this->redirect(['site/error', 'message' => 'Review not found', 'code' => 422]);
        }
        $review->delete();
        $shop->rating = round(ShopReview::find()->where(['status' => 1, 'shop_id' => $id])->average("rating"), 1);
        $shop->save();

        return $this->asJson([]);
    }
}
