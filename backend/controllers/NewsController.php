<?php

namespace backend\controllers;

use common\components\Helper;
use common\components\SimpleImage;
use common\models\FbToken;
use common\models\NewsTranslation;
use common\models\User;
use rmrevin\yii\fontawesome\FA;
use Yii;
use common\models\News;
use backend\models\NewsSearch;
use backend\controllers\BehaviorsController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends BehaviorsController
{

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $info = new NewsTranslation(['scenario' => 'create']);
        $info_uz = new NewsTranslation();
        $info_en = new NewsTranslation();
        $info_oz = new NewsTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = (__DIR__).'/../../uploads/news/';
            $info->news_id = $model->id;
            $info->name = (Yii::$app->request->post('NewsTranslation')['name']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['name']['ru']: '';
            $info->text = (Yii::$app->request->post('NewsTranslation')['text']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['text']['ru']: '';
            $info->short = (Yii::$app->request->post('NewsTranslation')['short']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['short']['ru']: '';
            $info->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['ru']: '';
            $info->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['ru']: '';
            $info->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['ru']: '';
            $info->local = 'ru-RU';
            $image_ru = UploadedFile::getInstanceByName('NewsTranslation[image][ru]');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    $resizer->save($dir.$image_name);
                    $info->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else $info->image = '/uploads/site/def_news.png';

//            $image_uz = UploadedFile::getInstanceByName('image[uz]');
//            $image_en = UploadedFile::getInstanceByName('image[en]');
            $info->save();

            $info_uz->news_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('NewsTranslation')['name']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['name']['uz']: $info->name;
            $info_uz->text = (Yii::$app->request->post('NewsTranslation')['text']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['text']['uz']: $info->text;
            $info_uz->short = (Yii::$app->request->post('NewsTranslation')['short']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['short']['uz']: $info->short;
            $info_uz->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['uz']: $info->meta_title;
            $info_uz->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['uz']: $info->meta_description;
            $info_uz->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['uz']: $info->meta_keys;
            $info_uz->local = 'uz-UZ';
            $image_uz = UploadedFile::getInstanceByName('NewsTranslation[image][uz]');
            if($image_uz){
                $path = $image_uz->baseName.'.'.$image_uz->extension;
                if($image_uz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_uz->extension;
                    $resizer->save($dir.$image_name);
                    $info_uz->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_uz->image = $info->image;
            }
            $info_uz->save();

            $info_en->news_id = $model->id;
            $info_en->name = (Yii::$app->request->post('NewsTranslation')['name']['en'] != '')? Yii::$app->request->post('NewsTranslation')['name']['en']: $info->name;
            $info_en->text = (Yii::$app->request->post('NewsTranslation')['text']['en'] != '')? Yii::$app->request->post('NewsTranslation')['text']['en']: $info->text;
            $info_en->short = (Yii::$app->request->post('NewsTranslation')['short']['en'] != '')? Yii::$app->request->post('NewsTranslation')['short']['en']: $info->short;
            $info_en->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['en'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['en']: $info->meta_title;
            $info_en->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['en'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['en']: $info->meta_description;
            $info_en->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['en'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['en']: $info->meta_keys;
            $info_en->local = 'en-EN';
            $image_en = UploadedFile::getInstanceByName('NewsTranslation[image][en]');
            if($image_en){
                $path = $image_en->baseName.'.'.$image_en->extension;
                if($image_en->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_en->extension;
                    $resizer->save($dir.$image_name);
                    $info_en->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_en->image = $info->image;
            }
            $info_en->save();

            $info_oz->news_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('NewsTranslation')['name']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['name']['oz']: $info->name;
            $info_oz->text = (Yii::$app->request->post('NewsTranslation')['text']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['text']['oz']: $info->text;
            $info_oz->short = (Yii::$app->request->post('NewsTranslation')['short']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['short']['oz']: $info->short;
            $info_oz->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['oz']: $info->meta_title;
            $info_oz->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['oz']: $info->meta_description;
            $info_oz->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['oz']: $info->meta_keys;
            $info_oz->local = 'oz-OZ';
            $image_oz = UploadedFile::getInstanceByName('NewsTranslation[image][oz]');
            if($image_oz){
                $path = $image_oz->baseName.'.'.$image_oz->extension;
                if($image_oz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_oz->extension;
                    $resizer->save($dir.$image_name);
                    $info_oz->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_oz->image = $info->image;
            }
            $info_oz->save();
            $model->url = (trim($model->url) == '')? Helper::toLatin($info->name):  Helper::toLatin($model->url);
            $model->save();


            $users = User::find()->where(['push' => 1])->asArray()->all();


            if ($users) {
                $users = ArrayHelper::map($users, 'id', 'id');

                $fbTokens = FbToken::find()->where(['in', 'user_id', array_values($users)])->asArray()->all();
            } else {
                $fbTokens = [];
            }


            if($fbTokens) {
                $fbTokens = ArrayHelper::map($fbTokens, 'id', 'token');

                $this->pushNotification('Новость', $model->translate->name, $fbTokens, 'news', $model->id, $model->translate->image);
            }

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

    protected function pushNotification($title, $msg, $tokens = array(), $type, $news_id = null, $photo) {
        $note = Yii::$app->fcm->createNotification($title, $msg);

        $chunk = array_chunk($tokens, 1000);

        foreach ($chunk as $v) {
            $message = Yii::$app->fcm->createMessage($v);

            $message->setNotification($note)->setData(['message'=>$msg, 'title'=>$title, 'type'=>$type, 'news_id'=>$news_id, 'date'=>time(), 'photo'=>$photo]);

            Yii::$app->fcm->send($message);
        }

        return true;
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $info = NewsTranslation::findOne(['news_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        $info_uz = (!empty(NewsTranslation::findOne(['news_id' => $model->id, 'local' => 'uz-UZ'])))? NewsTranslation::findOne(['news_id' => $model->id, 'local' => 'uz-UZ']): new NewsTranslation();
        $info_en = (!empty(NewsTranslation::findOne(['news_id' => $model->id, 'local' => 'en-EN'])))? NewsTranslation::findOne(['news_id' => $model->id, 'local' => 'en-EN']): new NewsTranslation();
        $info_oz = (!empty(NewsTranslation::findOne(['news_id' => $model->id, 'local' => 'oz-OZ'])))? NewsTranslation::findOne(['news_id' => $model->id, 'local' => 'oz-OZ']): new NewsTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = (__DIR__).'/../../uploads/news/';
            $info->news_id = $model->id;
            $info->name = (Yii::$app->request->post('NewsTranslation')['name']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['name']['ru']: '';
            $info->text = (Yii::$app->request->post('NewsTranslation')['text']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['text']['ru']: '';
            $info->short = (Yii::$app->request->post('NewsTranslation')['short']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['short']['ru']: '';
            $info->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['ru']: '';
            $info->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['ru']: '';
            $info->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['ru'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['ru']: '';
            $info->local = 'ru-RU';
            $image_ru = UploadedFile::getInstanceByName('NewsTranslation[image][ru]');
            if($image_ru){
                $path = $image_ru->baseName.'.'.$image_ru->extension;
                if($image_ru->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_ru->extension;
                    $resizer->save($dir.$image_name);
                    $info->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $info->save();

            $info_uz->news_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('NewsTranslation')['name']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['name']['uz']: $info->name;
            $info_uz->text = (Yii::$app->request->post('NewsTranslation')['text']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['text']['uz']: $info->text;
            $info_uz->short = (Yii::$app->request->post('NewsTranslation')['short']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['short']['uz']: $info->short;
            $info_uz->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['uz']: $info->meta_title;
            $info_uz->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['uz']: $info->meta_description;
            $info_uz->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['uz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['uz']: $info->meta_keys;
            $info_uz->local = 'uz-UZ';
            $image_uz = UploadedFile::getInstanceByName('NewsTranslation[image][uz]');
            if($image_uz){
                $path = $image_uz->baseName.'.'.$image_uz->extension;
                if($image_uz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_uz->extension;
                    $resizer->save($dir.$image_name);
                    $info_uz->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $info_uz->save();

            $info_en->news_id = $model->id;
            $info_en->name = (Yii::$app->request->post('NewsTranslation')['name']['en'] != '')? Yii::$app->request->post('NewsTranslation')['name']['en']: $info->name;
            $info_en->text = (Yii::$app->request->post('NewsTranslation')['text']['en'] != '')? Yii::$app->request->post('NewsTranslation')['text']['en']: $info->text;
            $info_en->short = (Yii::$app->request->post('NewsTranslation')['short']['en'] != '')? Yii::$app->request->post('NewsTranslation')['short']['en']: $info->short;
            $info_en->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['en'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['en']: $info->meta_title;
            $info_en->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['en'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['en']: $info->meta_description;
            $info_en->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['en'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['en']: $info->meta_keys;
            $info_en->local = 'en-EN';
            $image_en = UploadedFile::getInstanceByName('NewsTranslation[image][en]');
            if($image_en){
                $path = $image_en->baseName.'.'.$image_en->extension;
                if($image_en->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_en->extension;
                    $resizer->save($dir.$image_name);
                    $info_en->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            $info_en->save();


            $info_oz->news_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('NewsTranslation')['name']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['name']['oz']: $info->name;
            $info_oz->text = (Yii::$app->request->post('NewsTranslation')['text']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['text']['oz']: $info->text;
            $info_oz->short = (Yii::$app->request->post('NewsTranslation')['short']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['short']['oz']: $info->short;
            $info_oz->meta_title = (Yii::$app->request->post('NewsTranslation')['meta_title']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_title']['oz']: $info->meta_title;
            $info_oz->meta_description = (Yii::$app->request->post('NewsTranslation')['meta_description']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_description']['oz']: $info->meta_description;
            $info_oz->meta_keys = (Yii::$app->request->post('NewsTranslation')['meta_keys']['oz'] != '')? Yii::$app->request->post('NewsTranslation')['meta_keys']['oz']: $info->meta_keys;
            $info_oz->local = 'oz-OZ';
            $image_oz = UploadedFile::getInstanceByName('NewsTranslation[image][oz]');
            if($image_oz){
                $path = $image_oz->baseName.'.'.$image_oz->extension;
                if($image_oz->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['news']['image'][0], Yii::$app->params['imageSizes']['news']['image'][1]);
                    $image_name = uniqid().'.'.$image_oz->extension;
                    $resizer->save($dir.$image_name);
                    $info_oz->image = '/uploads/news/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else {
                $info_oz->image = $info->image;
            }
            $info_oz->save();

            $model->url = (trim($model->url) == '')? Helper::toLatin($info->name):  Helper::toLatin($model->url);
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
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
