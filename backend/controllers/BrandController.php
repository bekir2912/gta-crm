<?php

namespace backend\controllers;

use common\components\SimpleImage;
use Yii;
use common\models\Brand;
use backend\models\BrandSearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends BehaviorsController
{

    /**
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = (__DIR__).'/../../uploads/brands/';

            $logo = UploadedFile::getInstance($model,'logo');

            if($logo) {
                $path = $logo->baseName . '.' . $logo->extension;
                if ($logo->saveAs($dir . $path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir . $path);
                    $resizer->resize(Yii::$app->params['imageSizes']['brands']['logo'][0], Yii::$app->params['imageSizes']['brands']['logo'][1]);
                    $logo_name = uniqid() . '.' . $logo->extension;
                    $resizer->save($dir . $logo_name);
                    $model->logo = '/uploads/brands/' . $logo_name;
                    if (file_exists($dir . $path)) unlink($dir . $path);
                }
            }
            else $model->logo = '/uploads/site/default_cat.png';
            $model->save();

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_img = $model->logo;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = (__DIR__).'/../../uploads/brands/';

            $logo = UploadedFile::getInstance($model,'logo');

            if($logo) {
                $path = $logo->baseName . '.' . $logo->extension;
                if ($logo->saveAs($dir . $path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir . $path);
                    $resizer->resize(Yii::$app->params['imageSizes']['brands']['logo'][0], Yii::$app->params['imageSizes']['brands']['logo'][1]);
                    $logo_name = uniqid() . '.' . $logo->extension;
                    $resizer->save($dir . $logo_name);
                    if(file_exists((__DIR__).'/../..'.$old_img) && $old_img != '/uploads/site/default_cat.png') unlink((__DIR__).'/../..'.$old_img);
                    $model->logo = '/uploads/brands/' . $logo_name;
                    if (file_exists($dir . $path)) unlink($dir . $path);
                }
            }
            else $model->logo = $old_img;
            $model->save();

            $copy_id = Yii::$app->request->post('Copy');
            if($copy_id['category_id'] != '0' && $copy_id['category_id'] != $model->category_id) {
                $copy = new Brand($model->getAttributes());
                $copy->id = null;
                $copy->category_id = $copy_id['category_id'];
                $copy->save();
                return $this->redirect(['update', 'id' => $copy->id]);
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
