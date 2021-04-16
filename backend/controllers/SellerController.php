<?php

namespace backend\controllers;

use common\components\SmsService;
use common\models\Shop;
use common\models\User;
use Yii;
use common\models\Seller;
use backend\models\SellerSearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SellerController implements the CRUD actions for Seller model.
 */
class SellerController extends BehaviorsController
{

    /**
     * Lists all Seller models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SellerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//
//    /**
//     * Displays a single Seller model.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Seller model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seller(['scenario' => 'create']);

        $smsService = new SmsService();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->username = $smsService->clearPhone($model->phone);
            if(Seller::findByUsername($smsService->clearPhone($model->phone))){
                Yii::$app->session->setFlash("success", "Номер занят");
                return $this->goBack();
            }
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();

            $fuser = new User();
            $fuser->username = $model->phone; //$this->username;
            $fuser->name = $model->name; //$this->username;
//            $fuser->email = $model->email;
            $fuser->phone = $model->phone;
            $fuser->setPassword($model->password);
            $fuser->generateAuthKey();
            $fuser->generateAuthKey();
            $fuser->save();

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Seller model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario= 'admin';

        $smsService = new SmsService();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->username = $smsService->clearPhone($model->phone);
            if(Seller::findByUsername($smsService->clearPhone($model->phone))){
                Yii::$app->session->setFlash("success", "Номер занят");
                return $this->goBack();
            }
            if($model->password != '') {
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }
            if($model->status == 0) {
                Shop::updateAll(['status' => 0], ['seller_id' => $model->id]);
            }
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

//    /**
//     * Deletes an existing Seller model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }
    public function actionDelete($id)
    {
        $seller = $this->findModel($id);
        $seller->deleted_at = time();
        $seller->status = 0;
        $seller->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Seller model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seller the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seller::findOne(['id' => $id, 'deleted_at' => 0])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
