<?php

namespace store\controllers;

use common\components\Helper;
use common\components\SimpleImage;
use common\models\ShopAddresses;
use common\models\ShopReview;
use rmrevin\yii\fontawesome\FA;
use store\models\ReviewSearch;
use Yii;
use common\models\Shop;
use store\models\ShopSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ReviewController extends BehaviorsController
{
    /**
     * Lists all Shop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ShopReview::findOne(['shop_id' => Yii::$app->session->get('shop_id'), 'id' => $id, 'status' => 1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
