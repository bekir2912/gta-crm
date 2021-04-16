<?php

namespace backend\controllers;

use common\components\Helper;
use common\models\StaticPageTranslation;
use Yii;
use common\models\StaticPage;
use backend\models\StaticPageSearch;
use yii\web\NotFoundHttpException;

/**
 * StaticPageController implements the CRUD actions for StaticPage model.
 */
class StaticPageController extends BehaviorsController
{

    /**
     * Lists all StaticPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaticPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new StaticPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaticPage();
        $info = new StaticPageTranslation(['scenario' => 'create']);
        $info_uz = new StaticPageTranslation();
        $info_en = new StaticPageTranslation();
        $info_oz = new StaticPageTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $info->static_page_id = $model->id;
            $info->name = (Yii::$app->request->post('StaticPageTranslation')['name']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['ru']: '';
            $info->text = (Yii::$app->request->post('StaticPageTranslation')['text']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['ru']: '';
            $info->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['ru']: '';
            $info->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['ru']: '';
            $info->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            $info_uz->static_page_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('StaticPageTranslation')['name']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['uz']: $info->name;
            $info_uz->text = (Yii::$app->request->post('StaticPageTranslation')['text']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['uz']: $info->text;
            $info_uz->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['uz']: $info->meta_title;
            $info_uz->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['uz']: $info->meta_description;
            $info_uz->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['uz']: $info->meta_keys;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();

            $info_en->static_page_id = $model->id;
            $info_en->name = (Yii::$app->request->post('StaticPageTranslation')['name']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['en']: $info->name;
            $info_en->text = (Yii::$app->request->post('StaticPageTranslation')['text']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['en']: $info->text;
            $info_en->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['en']: $info->meta_title;
            $info_en->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['en']: $info->meta_description;
            $info_en->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['en']: $info->meta_keys;
            $info_en->local = 'en-EN';
            $info_en->save();

            $info_oz->static_page_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('StaticPageTranslation')['name']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['oz']: $info->name;
            $info_oz->text = (Yii::$app->request->post('StaticPageTranslation')['text']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['oz']: $info->text;
            $info_oz->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['oz']: $info->meta_title;
            $info_oz->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['oz']: $info->meta_description;
            $info_oz->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['oz']: $info->meta_keys;
            $info_oz->local = 'oz-OZ';
            $info_oz->save();
            $model->url = (trim($model->url) == '')? Helper::toLatin($info->name):  Helper::toLatin($model->url);
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
     * Updates an existing StaticPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $info = StaticPageTranslation::findOne(['static_page_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        $info_uz = (!empty(StaticPageTranslation::findOne(['static_page_id' => $model->id, 'local' => 'uz-UZ'])))? StaticPageTranslation::findOne(['static_page_id' => $model->id, 'local' => 'uz-UZ']): new StaticPageTranslation();
        $info_en = (!empty(StaticPageTranslation::findOne(['static_page_id' => $model->id, 'local' => 'en-EN'])))? StaticPageTranslation::findOne(['static_page_id' => $model->id, 'local' => 'en-EN']): new StaticPageTranslation();
        $info_oz = (!empty(StaticPageTranslation::findOne(['static_page_id' => $model->id, 'local' => 'oz-OZ'])))? StaticPageTranslation::findOne(['static_page_id' => $model->id, 'local' => 'oz-OZ']): new StaticPageTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $info->static_page_id = $model->id;
            $info->name = (Yii::$app->request->post('StaticPageTranslation')['name']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['ru']: '';
            $info->text = (Yii::$app->request->post('StaticPageTranslation')['text']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['ru']: '';
            $info->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['ru']: '';
            $info->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['ru']: '';
            $info->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['ru'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            $info_uz->static_page_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('StaticPageTranslation')['name']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['uz']: $info->name;
            $info_uz->text = (Yii::$app->request->post('StaticPageTranslation')['text']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['uz']: $info->text;
            $info_uz->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['uz']: $info->meta_title;
            $info_uz->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['uz']: $info->meta_description;
            $info_uz->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['uz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['uz']: $info->meta_keys;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();

            $info_en->static_page_id = $model->id;
            $info_en->name = (Yii::$app->request->post('StaticPageTranslation')['name']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['en']: $info->name;
            $info_en->text = (Yii::$app->request->post('StaticPageTranslation')['text']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['en']: $info->text;
            $info_en->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['en']: $info->meta_title;
            $info_en->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['en']: $info->meta_description;
            $info_en->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['en'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['en']: $info->meta_keys;
            $info_en->local = 'en-EN';
            $info_en->save();

            $info_oz->static_page_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('StaticPageTranslation')['name']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['name']['oz']: $info->name;
            $info_oz->text = (Yii::$app->request->post('StaticPageTranslation')['text']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['text']['oz']: $info->text;
            $info_oz->meta_title = (Yii::$app->request->post('StaticPageTranslation')['meta_title']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_title']['oz']: $info->meta_title;
            $info_oz->meta_description = (Yii::$app->request->post('StaticPageTranslation')['meta_description']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_description']['oz']: $info->meta_description;
            $info_oz->meta_keys = (Yii::$app->request->post('StaticPageTranslation')['meta_keys']['oz'] != '')? Yii::$app->request->post('StaticPageTranslation')['meta_keys']['oz']: $info->meta_keys;
            $info_oz->local = 'oz-OZ';
            $info_oz->save();
            $model->url = (trim($model->url) == '')? Helper::toLatin($info->name):  Helper::toLatin($model->url);
            $model->save();

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'info' => $info,
                'info_uz' => $info_uz,
                'info_en' => $info_en,
                'info_oz' => $info_oz,
            ]);
        }
    }

    /**
     * Deletes an existing StaticPage model.
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
     * Finds the StaticPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaticPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaticPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
