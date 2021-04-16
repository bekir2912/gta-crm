<?php

namespace backend\controllers;

use common\components\Helper;
use common\components\SimpleImage;
use common\models\Brand;
use common\models\CategoryTranslation;
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
class CategoryController extends BehaviorsController
{

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
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
        $model = new Category();
        $info = new CategoryTranslation(['scenario' => 'create']);
        $info_uz = new CategoryTranslation();
        $info_en = new CategoryTranslation();
        $info_oz = new CategoryTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->parent_id > 0) {
                $parent = Category::findOne($model->parent_id);
                $model->on_main = $parent->on_main;
                $model->spec = $parent->spec;
            } else {
                $model->parent_id = null;
            }

            $model->icon = '/uploads/site/test_icon.png';
            $model->url = '_'.uniqid();
            $model->save();
            $image = UploadedFile::getInstanceByName('Category[icon]');
            $dir = (__DIR__).'/../../uploads/categories/';
                if($image){
                    $path = $image->baseName.'.'.$image->extension;
                    if($image->saveAs($dir.$path)) {
                        $resizer = new SimpleImage();
                        $resizer->load($dir.$path);
                        $resizer->resize(Yii::$app->params['imageSizes']['categories']['icon'][0], Yii::$app->params['imageSizes']['categories']['icon'][1]);
                        $image_name = uniqid().'.'.$image->extension;
                        $resizer->save($dir.$image_name);
                        $model->icon = '/uploads/categories/'.$image_name;
                        if(file_exists($dir.$path)) unlink($dir.$path);

                        $model->save();
                    }
                    else {
                        Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                        return $this->goBack();
                    }
                }

            $info->category_id = $model->id;
            $info->name = (Yii::$app->request->post('CategoryTranslation')['name']['ru'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['ru']: '';
            $info->description = (Yii::$app->request->post('CategoryTranslation')['description']['ru'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['ru']: '';
            $info->local = 'ru-RU';
            $image_ru = UploadedFile::getInstanceByName('CategoryTranslation[image][ru]');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    $resizer->save($dir.$image_name);
                    $info->image = '/uploads/categories/'.$image_name;
                    if(is_file($dir.$path)) if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else $info->image = '/uploads/site/default_cat.png';

//            $image_uz = UploadedFile::getInstanceByName('image[uz]');
//            $image_en = UploadedFile::getInstanceByName('image[en]');
            $info->save();

            $info_uz->category_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('CategoryTranslation')['name']['uz'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['uz']: $info->name;
            $info_uz->description = (Yii::$app->request->post('CategoryTranslation')['description']['uz'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['uz']: $info->description;
            $info_uz->local = 'uz-UZ';
            $image_uz = UploadedFile::getInstanceByName('CategoryTranslation[image][uz]');
            if($image_uz){
                $path = $image_uz->baseName.'.'.$image_uz->extension;
                if($image_uz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_uz->extension;
                    $resizer->save($dir.$image_name);
                    $info_uz->image = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_uz->image = $info->image;
            }
            $info_uz->save();

            $info_en->category_id = $model->id;
            $info_en->name = (Yii::$app->request->post('CategoryTranslation')['name']['en'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['en']: $info->name;
            $info_en->description = (Yii::$app->request->post('CategoryTranslation')['description']['en'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['en']: $info->description;
            $info_en->local = 'en-EN';
            $image_en = UploadedFile::getInstanceByName('CategoryTranslation[image][en]');
            if($image_en){
                $path = $image_en->baseName.'.'.$image_en->extension;
                if($image_en->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_en->extension;
                    $resizer->save($dir.$image_name);
                    $info_en->image = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_en->image = $info->image;
            }
            $info_en->save();

            $info_oz->category_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('CategoryTranslation')['name']['oz'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['oz']: $info->name;
            $info_oz->description = (Yii::$app->request->post('CategoryTranslation')['description']['oz'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['oz']: $info->description;
            $info_oz->local = 'oz-OZ';
            $image_oz = UploadedFile::getInstanceByName('CategoryTranslation[image][oz]');
            if($image_oz){
                $path = $image_oz->baseName.'.'.$image_oz->extension;
                if($image_oz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_oz->extension;
                    $resizer->save($dir.$image_name);
                    $info_oz->image = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_oz->image = $info->image;
            }
            $info_oz->save();

            $model->url = Helper::toLatin($info->name).'_'.$model->id;
            $model->save();
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
        $old_img = $model->icon;
        $info = CategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        $info_uz = (!empty(CategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'uz-UZ'])))? CategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'uz-UZ']): new CategoryTranslation();
        $info_en = (!empty(CategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'en-EN'])))? CategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'en-EN']): new CategoryTranslation();
        $info_oz = (!empty(CategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'oz-OZ'])))? CategoryTranslation::findOne(['category_id' => $model->id, 'local' => 'oz-OZ']): new CategoryTranslation();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($model->parent_id > 0) {
                $parent = Category::findOne($model->parent_id);
                $model->on_main = $parent->on_main;
                $model->spec = $parent->spec;
            } else {
                $model->parent_id = null;
            }
            $model->save();
            $image = UploadedFile::getInstanceByName('Category[icon]');
            $dir = (__DIR__).'/../../uploads/categories/';
            if($image){
                $path = $image->baseName.'.'.$image->extension;
                if($image->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['icon'][0], Yii::$app->params['imageSizes']['categories']['icon'][1]);
                    $image_name = uniqid().'.'.$image->extension;
                    $resizer->save($dir.$image_name);
                    $model->icon = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);

                    $model->save();
                }
                else {
                    Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                    return $this->goBack();
                }
            }
            else {
                $model->icon = $old_img;
                $model->save();
            }
            $info->category_id = $model->id;
            $info->name = (Yii::$app->request->post('CategoryTranslation')['name']['ru'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['ru']: '';
            $info->description = (Yii::$app->request->post('CategoryTranslation')['description']['ru'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['ru']: '';
            $info->local = 'ru-RU';
            $image_ru = UploadedFile::getInstanceByName('CategoryTranslation[image][ru]');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    $resizer->save($dir.$image_name);
                    $info->image = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }

//            $image_uz = UploadedFile::getInstanceByName('image[uz]');
//            $image_en = UploadedFile::getInstanceByName('image[en]');
            $info->save();

            $info_uz->category_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('CategoryTranslation')['name']['uz'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['uz']: $info->name;
            $info_uz->description = (Yii::$app->request->post('CategoryTranslation')['description']['uz'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['uz']: $info->description;
            $info_uz->local = 'uz-UZ';
            $image_uz = UploadedFile::getInstanceByName('CategoryTranslation[image][uz]');
            if($image_uz){
                $path = $image_uz->baseName.'.'.$image_uz->extension;
                if($image_uz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_uz->extension;
                    $resizer->save($dir.$image_name);
                    $info_uz->image = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $info_uz->save();

            $info_en->category_id = $model->id;
            $info_en->name = (Yii::$app->request->post('CategoryTranslation')['name']['en'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['en']: $info->name;
            $info_en->description = (Yii::$app->request->post('CategoryTranslation')['description']['en'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['en']: $info->description;
            $info_en->local = 'en-EN';
            $image_en = UploadedFile::getInstanceByName('CategoryTranslation[image][en]');
            if($image_en){
                $path = $image_en->baseName.'.'.$image_en->extension;
                if($image_en->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_en->extension;
                    $resizer->save($dir.$image_name);
                    $info_en->image = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $info_en->save();


            $info_oz->category_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('CategoryTranslation')['name']['oz'] != '')? Yii::$app->request->post('CategoryTranslation')['name']['oz']: $info->name;
            $info_oz->description = (Yii::$app->request->post('CategoryTranslation')['description']['oz'] != '')? Yii::$app->request->post('CategoryTranslation')['description']['oz']: $info->description;
            $info_oz->local = 'oz-OZ';
            $image_oz = UploadedFile::getInstanceByName('CategoryTranslation[image][oz]');
            if($image_oz){
                $path = $image_oz->baseName.'.'.$image_oz->extension;
                if($image_oz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['categories']['image'][0], Yii::$app->params['imageSizes']['categories']['image'][1]);
                    $image_name = uniqid().'.'.$image_oz->extension;
                    $resizer->save($dir.$image_name);
                    $info_oz->image = '/uploads/categories/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_oz->image = $info->image;
            }
            $info_oz->save();

            $model->url = Helper::toLatin($info->name).'_'.$model->id;
            $model->save();
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
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
