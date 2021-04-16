<?php

namespace backend\controllers;

use common\models\Message;
use Yii;
use common\models\SourceMessage;
use backend\models\SourceMessageSearch;
use yii\web\NotFoundHttpException;

/**
 * MessageController implements the CRUD actions for SourceMessage model.
 */
class MessageController extends BehaviorsController
{

    /**
     * Lists all SourceMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//
//    /**
//     * Displays a single SourceMessage model.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
//
//    /**
//     * Creates a new SourceMessage model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new SourceMessage();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing SourceMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_uz = Message::find()->where(['id' => $id, 'language' => 'uz-UZ'])->all();
        $model_en = Message::find()->where(['id' => $id, 'language' => 'en-EN'])->all();
        $model_oz = Message::find()->where(['id' => $id, 'language' => 'oz-OZ'])->all();
        if(empty($model_uz[0])) $model_uz = new Message();
        else $model_uz = $model_uz[0];
        if(empty($model_en[0])) $model_en = new Message();
        else $model_en = $model_en[0];
        if(empty($model_oz[0])) $model_oz = new Message();
        else $model_oz = $model_oz[0];

        if ($model->load(Yii::$app->request->post())) {
            $model->translation = (Yii::$app->request->post('Message')['translation']['ru'] != '')? Yii::$app->request->post('Message')['translation']['ru']: '';
            $model->save();
            $model_uz->id = $model->id;
            $model_uz->translation = (Yii::$app->request->post('Message')['translation']['uz'] != '')? Yii::$app->request->post('Message')['translation']['uz']:$model->translation;
            $model_uz->language = 'uz-UZ';
            $model_uz->save();
            $model_en->id = $model->id;
            $model_en->translation = (Yii::$app->request->post('Message')['translation']['en'] != '')? Yii::$app->request->post('Message')['translation']['en']:$model->translation;
            $model_en->language = 'en-EN';
            $model_en->save();
            $model_oz->id = $model->id;
            $model_oz->translation = (Yii::$app->request->post('Message')['translation']['oz'] != '')? Yii::$app->request->post('Message')['translation']['oz']:$model->translation;
            $model_oz->language = 'oz-OZ';
            $model_oz->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_uz' => $model_uz,
                'model_oz' => $model_oz,
                'model_en' => $model_en,
            ]);
        }
    }
//
//    /**
//     * Deletes an existing SourceMessage model.
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

    /**
     * Finds the SourceMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SourceMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Message::find()->where(['id' => $id, 'language' => 'ru-RU'])->all();
        if (!empty($model)) {
            return $model[0];
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
