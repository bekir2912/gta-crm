<?php

namespace backend\controllers;

use common\models\StaticPageCategoryTranslation;
use Yii;
use common\models\StaticPageCategory;
use backend\models\StaticPageCategorySearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaticPageCategoryController implements the CRUD actions for StaticPageCategory model.
 */
class StaticPageCategoryController extends BehaviorsController
{

    /**
     * Lists all StaticPageCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaticPageCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//
//    /**
//     * Displays a single StaticPageCategory model.
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
     * Creates a new StaticPageCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaticPageCategory();
        $info = new StaticPageCategoryTranslation(['scenario' => 'create']);
        $info_uz = new StaticPageCategoryTranslation();
        $info_en = new StaticPageCategoryTranslation();
        $info_oz = new StaticPageCategoryTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $info->category_id = $model->id;
            $info->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['ru'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();
            $info_uz->category_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['uz'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['uz']: $info->name;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();
            $info_en->category_id = $model->id;
            $info_en->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['en'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['en']: $info->name;
            $info_en->local = 'en-EN';
            $info_en->save();
            $info_oz->category_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['oz'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['oz']: $info->name;
            $info_oz->local = 'oz-OZ';
            $info_oz->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'info' => $info,
                'info_uz' => $info_uz,
                'info_oz' => $info_oz,
                'info_en' => $info_en,
            ]);
        }
    }

    /**
     * Updates an existing StaticPageCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $info = StaticPageCategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        $info_uz = (!empty(StaticPageCategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'uz-UZ'])))? StaticPageCategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'uz-UZ']): new StaticPageCategoryTranslation();
        $info_en = (!empty(StaticPageCategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'en-EN'])))? StaticPageCategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'en-EN']): new StaticPageCategoryTranslation();
        $info_oz = (!empty(StaticPageCategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'oz-OZ'])))? StaticPageCategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'oz-OZ']): new StaticPageCategoryTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $info->category_id = $model->id;
            $info->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['ru'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();
            $info_uz->category_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['uz'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['uz']: $info->name;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();
            $info_en->category_id = $model->id;
            $info_en->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['en'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['en']: $info->name;
            $info_en->local = 'en-EN';
            $info_en->save();
            $info_oz->category_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('StaticPageCategoryTranslation')['name']['oz'] != '')? Yii::$app->request->post('StaticPageCategoryTranslation')['name']['oz']: $info->name;
            $info_oz->local = 'oz-OZ';
            $info_oz->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'info' => $info,
                'info_uz' => $info_uz,
                'info_oz' => $info_oz,
                'info_en' => $info_en,
            ]);
        }
    }

    /**
     * Deletes an existing StaticPageCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StaticPageCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaticPageCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaticPageCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
