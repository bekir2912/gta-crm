<?php

namespace backend\controllers;

use backend\models\CitySearch;
use common\components\Helper;
use common\components\SimpleImage;
use common\models\Brand;
use common\models\CategoryTranslation;
use common\models\City;
use common\models\CityTranslation;
use common\models\ProductImages;
use rmrevin\yii\fontawesome\FA;
use Yii;
use common\models\Category;
use backend\models\CategorySearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CityController extends BehaviorsController
{

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new City();
        $info = new CityTranslation(['scenario' => 'create']);
        $info_uz = new CityTranslation();
        $info_en = new CityTranslation();
        $info_oz = new CityTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $info->city_id = $model->id;
            $info->name = (Yii::$app->request->post('CityTranslation')['name']['ru'] != '')? Yii::$app->request->post('CityTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            $info_uz->city_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('CityTranslation')['name']['uz'] != '')? Yii::$app->request->post('CityTranslation')['name']['uz']: $info->name;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();

            $info_en->city_id = $model->id;
            $info_en->name = (Yii::$app->request->post('CityTranslation')['name']['en'] != '')? Yii::$app->request->post('CityTranslation')['name']['en']: $info->name;
            $info_en->local = 'en-EN';
            $info_en->save();
            $info_oz->city_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('CityTranslation')['name']['oz'] != '')? Yii::$app->request->post('CityTranslation')['name']['oz']: $info->name;
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
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $info = CityTranslation::findOne(['city_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        $info_uz = (!empty(CityTranslation::findOne(['city_id' => $model->id, 'local' => 'uz-UZ'])))? CityTranslation::findOne(['city_id' => $model->id, 'local' => 'uz-UZ']): new CityTranslation();
        $info_en = (!empty(CityTranslation::findOne(['city_id' => $model->id, 'local' => 'en-EN'])))? CityTranslation::findOne(['city_id' => $model->id, 'local' => 'en-EN']): new CityTranslation();
        $info_oz = (!empty(CityTranslation::findOne(['city_id' => $model->id, 'local' => 'oz-OZ'])))? CityTranslation::findOne(['city_id' => $model->id, 'local' => 'oz-OZ']): new CityTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $info->city_id = $model->id;
            $info->name = (Yii::$app->request->post('CityTranslation')['name']['ru'] != '')? Yii::$app->request->post('CityTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            $info_uz->city_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('CityTranslation')['name']['uz'] != '')? Yii::$app->request->post('CityTranslation')['name']['uz']: $info->name;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();

            $info_en->city_id = $model->id;
            $info_en->name = (Yii::$app->request->post('CityTranslation')['name']['en'] != '')? Yii::$app->request->post('CityTranslation')['name']['en']: $info->name;
            $info_en->local = 'en-EN';
            $info_en->save();

            $info_oz->city_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('CityTranslation')['name']['oz'] != '')? Yii::$app->request->post('CityTranslation')['name']['oz']: $info->name;
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
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
