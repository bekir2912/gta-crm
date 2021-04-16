<?php

namespace backend\controllers;

use backend\models\ReviewSearch;
use common\models\ShopReview;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * SocialController implements the CRUD actions for Social model.
 */
class ReviewController extends BehaviorsController
{

    /**
     * Lists all Social models.
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->shop->rating = round(ShopReview::find()->where(['status' => 1, 'shop_id' => $model->shop->id])->average("rating"), 1);
            $model->is_moderated = 1;
            $model->save();
            $model->shop->save();
            return $this->redirect(['index', 'sort' => '-id']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $shop = $model->shop;
        $model->delete();
        $shop->rating = round(ShopReview::find()->where(['status' => 1, 'shop_id' => $shop->id])->average("rating"), 1);
        $shop->save();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = ShopReview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
