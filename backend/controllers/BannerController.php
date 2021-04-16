<?php

namespace backend\controllers;

use common\components\SimpleImage;
use common\models\BannerTranslation;
use Yii;
use common\models\Banner;
use backend\models\BannerSearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends BehaviorsController
{

    /**
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * Displays a single Banner model.
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
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();
        $info = new BannerTranslation();
        $info_uz = new BannerTranslation();
        $info_en = new BannerTranslation();
        $info_oz = new BannerTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->expires_in = strtotime(str_replace('.', '-', $model->expires_in));
            $model->save();
            $dir = (__DIR__).'/../../uploads/banners/';
            $info->banner_id = $model->id;
            $info->name = (Yii::$app->request->post('BannerTranslation')['name']['ru'] != '')? Yii::$app->request->post('BannerTranslation')['name']['ru']: '';
            $info->description = (Yii::$app->request->post('BannerTranslation')['description']['ru'] != '')? Yii::$app->request->post('BannerTranslation')['description']['ru']: '';
            $info->url = (Yii::$app->request->post('BannerTranslation')['url']['ru'] != '')? Yii::$app->request->post('BannerTranslation')['url']['ru']: '';
            $info->local = 'ru-RU';
            $image_ru = UploadedFile::getInstanceByName('BannerTranslation[image][ru]');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    rename($dir.$path, $dir.$image_name);
//                    $resizer->save($dir.$image_name);
                    $info->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }

//            $image_uz = UploadedFile::getInstanceByName('image[uz]');
//            $image_en = UploadedFile::getInstanceByName('image[en]');
            $info->save();

            $info_uz->banner_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('BannerTranslation')['name']['uz'] != '')? Yii::$app->request->post('BannerTranslation')['name']['uz']: $info->name;
            $info_uz->description = (Yii::$app->request->post('BannerTranslation')['description']['uz'] != '')? Yii::$app->request->post('BannerTranslation')['description']['uz']: $info->description;
            $info_uz->url = (Yii::$app->request->post('BannerTranslation')['url']['uz'] != '')? Yii::$app->request->post('BannerTranslation')['url']['uz']: $info->url;
            $info_uz->local = 'uz-UZ';
            $image_uz = UploadedFile::getInstanceByName('BannerTranslation[image][uz]');
            if($image_uz){
                $path = $image_uz->baseName.'.'.$image_uz->extension;
                if($image_uz->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_uz->extension;
//                    $resizer->save($dir.$image_name);
                    rename($dir.$path, $dir.$image_name);
                    $info_uz->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_uz->image = $info->image;
            }
            $info_uz->save();

            $info_en->banner_id = $model->id;
            $info_en->name = (Yii::$app->request->post('BannerTranslation')['name']['en'] != '')? Yii::$app->request->post('BannerTranslation')['name']['en']: $info->name;
            $info_en->description = (Yii::$app->request->post('BannerTranslation')['description']['en'] != '')? Yii::$app->request->post('BannerTranslation')['description']['en']: $info->description;
            $info_en->url = (Yii::$app->request->post('BannerTranslation')['url']['en'] != '')? Yii::$app->request->post('BannerTranslation')['url']['en']: $info->url;
            $info_en->local = 'en-EN';
            $image_en = UploadedFile::getInstanceByName('BannerTranslation[image][en]');
            if($image_en){
                $path = $image_en->baseName.'.'.$image_en->extension;
                if($image_en->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_en->extension;
//                    $resizer->save($dir.$image_name);
                    rename($dir.$path, $dir.$image_name);
                    $info_en->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_en->image = $info->image;
            }
            $info_en->save();

            $info_oz->banner_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('BannerTranslation')['name']['oz'] != '')? Yii::$app->request->post('BannerTranslation')['name']['oz']: $info->name;
            $info_oz->description = (Yii::$app->request->post('BannerTranslation')['description']['oz'] != '')? Yii::$app->request->post('BannerTranslation')['description']['oz']: $info->description;
            $info_oz->url = (Yii::$app->request->post('BannerTranslation')['url']['oz'] != '')? Yii::$app->request->post('BannerTranslation')['url']['oz']: $info->url;
            $info_oz->local = 'oz-OZ';
            $image_oz = UploadedFile::getInstanceByName('BannerTranslation[image][oz]');
            if($image_oz){
                $path = $image_oz->baseName.'.'.$image_oz->extension;
                if($image_oz->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_oz->extension;
//                    $resizer->save($dir.$image_name);
                    rename($dir.$path, $dir.$image_name);
                    $info_oz->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_oz->image = $info->image;
            }
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
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $info = BannerTranslation::findOne(['banner_id' => $model->id, 'local' => 'ru-RU']);
        $info_uz = (!empty(BannerTranslation::findOne(['banner_id' => $model->id, 'local' => 'uz-UZ'])))? BannerTranslation::findOne(['banner_id' => $model->id, 'local' => 'uz-UZ']): new BannerTranslation();
        $info_en = (!empty(BannerTranslation::findOne(['banner_id' => $model->id, 'local' => 'en-EN'])))? BannerTranslation::findOne(['banner_id' => $model->id, 'local' => 'en-EN']): new BannerTranslation();
        $info_oz = (!empty(BannerTranslation::findOne(['banner_id' => $model->id, 'local' => 'oz-OZ'])))? BannerTranslation::findOne(['banner_id' => $model->id, 'local' => 'oz-OZ']): new BannerTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->expires_in = strtotime(str_replace('.', '-', $model->expires_in));
            $model->save();
            $dir = (__DIR__).'/../../uploads/banners/';
            $info->banner_id = $model->id;
            $info->name = (Yii::$app->request->post('BannerTranslation')['name']['ru'] != '')? Yii::$app->request->post('BannerTranslation')['name']['ru']: '';
            $info->description = (Yii::$app->request->post('BannerTranslation')['description']['ru'] != '')? Yii::$app->request->post('BannerTranslation')['description']['ru']: '';
            $info->url = (Yii::$app->request->post('BannerTranslation')['url']['ru'] != '')? Yii::$app->request->post('BannerTranslation')['url']['ru']: '';
            $info->local = 'ru-RU';
            $image_ru = UploadedFile::getInstanceByName('BannerTranslation[image][ru]');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    rename($dir.$path, $dir.$image_name);
//                    $resizer->save($dir.$image_name);
                    $info->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }

//            $image_uz = UploadedFile::getInstanceByName('image[uz]');
//            $image_en = UploadedFile::getInstanceByName('image[en]');
            $info->save();

            $info_uz->banner_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('BannerTranslation')['name']['uz'] != '')? Yii::$app->request->post('BannerTranslation')['name']['uz']: $info->name;
            $info_uz->description = (Yii::$app->request->post('BannerTranslation')['description']['uz'] != '')? Yii::$app->request->post('BannerTranslation')['description']['uz']: $info->description;
            $info_uz->url = (Yii::$app->request->post('BannerTranslation')['url']['uz'] != '')? Yii::$app->request->post('BannerTranslation')['url']['uz']: $info->url;
            $info_uz->local = 'uz-UZ';
            $image_uz = UploadedFile::getInstanceByName('BannerTranslation[image][uz]');
            if($image_uz){
                $path = $image_uz->baseName.'.'.$image_uz->extension;
                if($image_uz->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_uz->extension;
                    rename($dir.$path, $dir.$image_name);
//                    $resizer->save($dir.$image_name);
                    $info_uz->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $info_uz->save();

            $info_en->banner_id = $model->id;
            $info_en->name = (Yii::$app->request->post('BannerTranslation')['name']['en'] != '')? Yii::$app->request->post('BannerTranslation')['name']['en']: $info->name;
            $info_en->description = (Yii::$app->request->post('BannerTranslation')['description']['en'] != '')? Yii::$app->request->post('BannerTranslation')['description']['en']: $info->description;
            $info_en->url = (Yii::$app->request->post('BannerTranslation')['url']['en'] != '')? Yii::$app->request->post('BannerTranslation')['url']['en']: $info->url;
            $info_en->local = 'en-EN';
            $image_en = UploadedFile::getInstanceByName('BannerTranslation[image][en]');
            if($image_en){
                $path = $image_en->baseName.'.'.$image_en->extension;
                if($image_en->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_en->extension;
//                    $resizer->save($dir.$image_name);
                    rename($dir.$path, $dir.$image_name);
                    $info_en->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $info_en->save();
            $info_oz->banner_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('BannerTranslation')['name']['oz'] != '')? Yii::$app->request->post('BannerTranslation')['name']['oz']: $info->name;
            $info_oz->description = (Yii::$app->request->post('BannerTranslation')['description']['oz'] != '')? Yii::$app->request->post('BannerTranslation')['description']['oz']: $info->description;
            $info_oz->url = (Yii::$app->request->post('BannerTranslation')['url']['oz'] != '')? Yii::$app->request->post('BannerTranslation')['url']['oz']: $info->url;
            $info_oz->local = 'oz-OZ';
            $image_oz = UploadedFile::getInstanceByName('BannerTranslation[image][oz]');
            if($image_oz){
                $path = $image_oz->baseName.'.'.$image_oz->extension;
                if($image_oz->saveAs($dir.$path)) {
//                    $resizer = new SimpleImage();
//                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['banners']['image'][0], Yii::$app->params['imageSizes']['banners']['image'][1]);
                    $image_name = uniqid().'.'.$image_oz->extension;
//                    $resizer->save($dir.$image_name);
                    rename($dir.$path, $dir.$image_name);
                    $info_oz->image = '/uploads/banners/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_oz->image = $info->image;
            }
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
     * Deletes an existing Banner model.
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
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
