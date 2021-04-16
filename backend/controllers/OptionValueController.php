<?php

namespace backend\controllers;

use common\components\SimpleImage;
use common\models\OptionValuesTranslation;
use Yii;
use common\models\OptionValue;
use backend\models\OptionValueSearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * OptionValueController implements the CRUD actions for OptionValue model.
 */
class OptionValueController extends BehaviorsController
{

    /**
     * Lists all OptionValue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OptionValueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new OptionValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OptionValue();

        $info = new OptionValuesTranslation(['scenario' => 'create']);
        // $info_uz = new OptionValuesTranslation();
        // $info_en = new OptionValuesTranslation();
        // $info_oz = new OptionValuesTranslation();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = (__DIR__).'/../../uploads/options/';
            $image_ru = UploadedFile::getInstance($model, 'image');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['options']['image'][0], Yii::$app->params['imageSizes']['options']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    $resizer->save($dir.$image_name);
                    $model->image = '/uploads/options/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $model->save();

            $info->option_id = $model->id;
            $info->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['ru'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            // $info_uz->option_id = $model->id;
            // $info_uz->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['uz'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['uz']: $info->name;
            // $info_uz->local = 'uz-UZ';
            // $info_uz->save();

            // $info_en->option_id = $model->id;
            // $info_en->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['en'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['en']: $info->name;
            // $info_en->local = 'en-EN';
            // $info_en->save();

            // $info_oz->option_id = $model->id;
            // $info_oz->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['oz'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['oz']: $info->name;
            // $info_oz->local = 'oz-OZ';
            // $info_oz->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'info' => $info,
                // 'info_uz' => $info_uz,
                // 'info_oz' => $info_oz,
                // 'info_en' => $info_en,
            ]);
        }
    }

    /**
     * Updates an existing OptionValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_image = $model->image;
        $info = OptionValuesTranslation::findOne(['option_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        // $info_uz = (!empty(OptionValuesTranslation::findOne(['option_id' => $model->id, 'local' => 'uz-UZ'])))? OptionValuesTranslation::findOne(['option_id' => $model->id, 'local' => 'uz-UZ']): new OptionValuesTranslation();
        // $info_en = (!empty(OptionValuesTranslation::findOne(['option_id' => $model->id, 'local' => 'en-EN'])))? OptionValuesTranslation::findOne(['option_id' => $model->id, 'local' => 'en-EN']): new OptionValuesTranslation();
        // $info_oz = (!empty(OptionValuesTranslation::findOne(['option_id' => $model->id, 'local' => 'oz-OZ'])))? OptionValuesTranslation::findOne(['option_id' => $model->id, 'local' => 'oz-OZ']): new OptionValuesTranslation();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = (__DIR__).'/../../uploads/options/';
            $image_ru = UploadedFile::getInstance($model, 'image');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['options']['image'][0], Yii::$app->params['imageSizes']['options']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    $resizer->save($dir.$image_name);
                    $model->image = '/uploads/options/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else $model->image = $old_image;
            $model->save();
            $info->option_id = $model->id;
            $info->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['ru'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            // $info_uz->option_id = $model->id;
            // $info_uz->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['uz'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['uz']: $info->name;
            // $info_uz->local = 'uz-UZ';
            // $info_uz->save();

            // $info_en->option_id = $model->id;
            // $info_en->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['en'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['en']: $info->name;
            // $info_en->local = 'en-EN';
            // $info_en->save();

            // $info_oz->option_id = $model->id;
            // $info_oz->name = (Yii::$app->request->post('OptionValuesTranslation')['name']['oz'] != '')? Yii::$app->request->post('OptionValuesTranslation')['name']['oz']: $info->name;
            // $info_oz->local = 'oz-OZ';
            // $info_oz->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'info' => $info,
                // 'info_uz' => $info_uz,
                // 'info_oz' => $info_oz,
                // 'info_en' => $info_en,
            ]);
        }
    }

    /**
     * Deletes an existing OptionValue model.
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
     * Finds the OptionValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OptionValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OptionValue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
