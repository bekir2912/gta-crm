<?php

namespace store\controllers;

use rmrevin\yii\fontawesome\FA;
use Yii;
use common\models\Seller;
use store\models\SellerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SellerController implements the CRUD actions for Seller model.
 */
class SellerController extends BehaviorsController
{

    /**
     * Updates an existing Seller model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        if (($model = SellerSearch::findOne(['id' => Yii::$app->user->id, 'deleted_at' => 0])) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (Yii::$app->request->post('SellerSearch')['password'] != '') {
                $model->setPassword(Yii::$app->request->post('SellerSearch')['password']);
                $model->save();
                Yii::$app->user->login($model);
            } else $model->save();

            Yii::$app->session->setFlash('success', FA::i('check').' '.Yii::t('frontend', 'Updated'));
            return $this->redirect(['update']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
