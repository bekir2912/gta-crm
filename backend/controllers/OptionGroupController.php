<?php

namespace backend\controllers;

use common\models\OptionGroupsTranslation;
use common\models\OptionValue;
use common\models\OptionValuesTranslation;
use Yii;
use common\models\OptionGroup;
use backend\models\OptionGroupSearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OptionGroupController implements the CRUD actions for OptionGroup model.
 */
class OptionGroupController extends BehaviorsController
{

    /**
     * Lists all OptionGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OptionGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new OptionGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OptionGroup();
        $info = new OptionGroupsTranslation(['scenario' => 'create']);
        $info_uz = new OptionGroupsTranslation();
        $info_en = new OptionGroupsTranslation();
        $info_oz = new OptionGroupsTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $info->group_id = $model->id;
            $info->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['ru'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            $info_uz->group_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['uz'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['uz']: $info->name;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();

            $info_en->group_id = $model->id;
            $info_en->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['en'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['en']: $info->name;
            $info_en->local = 'en-EN';
            $info_en->save();

            $info_oz->group_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['oz'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['oz']: $info->name;
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
     * Updates an existing OptionGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $info = OptionGroupsTranslation::findOne(['group_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        $info_uz = (!empty(OptionGroupsTranslation::findOne(['group_id' => $model->id, 'local' => 'uz-UZ'])))? OptionGroupsTranslation::findOne(['group_id' => $model->id, 'local' => 'uz-UZ']): new OptionGroupsTranslation();
        $info_en = (!empty(OptionGroupsTranslation::findOne(['group_id' => $model->id, 'local' => 'en-EN'])))? OptionGroupsTranslation::findOne(['group_id' => $model->id, 'local' => 'en-EN']): new OptionGroupsTranslation();
        $info_oz = (!empty(OptionGroupsTranslation::findOne(['group_id' => $model->id, 'local' => 'oz-OZ'])))? OptionGroupsTranslation::findOne(['group_id' => $model->id, 'local' => 'oz-OZ']): new OptionGroupsTranslation();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $copy_id = Yii::$app->request->post('Copy');
            if($copy_id['category_id'] != '0' && $copy_id['category_id'] != $model->category_id) {
                $copy = new OptionGroup($model->getAttributes());
                $copy->id = null;
                $copy->category_id = $copy_id['category_id'];
                $copy->save();
                $translations = !empty($model->optionGroupTranslation)? $model->optionGroupTranslation: [];
                if(!empty($translations)) {
                    foreach ($translations as $translation) {
                        $copy_trans = new OptionGroupsTranslation($translation->getAttributes());
                        $copy_trans->id = null;
                        $copy_trans->group_id = $copy->id;
                        $copy_trans->save();
                    }
                }
                $options = !empty($model->optionValue)? $model->optionValue: [];
                if(!empty($options)) {
                    foreach ($options as $option) {
                        $copy_option = new OptionValue($option->getAttributes());
                        $copy_option->id = null;
                        $copy_option->group_id = $copy->id;
                        $copy_option->save();
                        $op_trans = !empty($option->optionValuesTranslation)? $option->optionValuesTranslation: [];
                        if(!empty($op_trans)) {
                            foreach ($op_trans as $op_tran) {
                                $copy_option_trans = new OptionValuesTranslation($op_tran->getAttributes());
                                $copy_option_trans->id = null;
                                $copy_option_trans->option_id = $copy_option->id;
                                $copy_option_trans->save();
                            }
                        }
                    }
                }

                return $this->redirect(['update', 'id' => $copy->id]);
            }
            $info->group_id = $model->id;
            $info->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['ru'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['ru']: '';
            $info->local = 'ru-RU';
            $info->save();

            $info_uz->group_id = $model->id;
            $info_uz->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['uz'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['uz']: $info->name;
            $info_uz->local = 'uz-UZ';
            $info_uz->save();

            $info_en->group_id = $model->id;
            $info_en->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['en'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['en']: $info->name;
            $info_en->local = 'en-EN';
            $info_en->save();

            $info_oz->group_id = $model->id;
            $info_oz->name = (Yii::$app->request->post('OptionGroupsTranslation')['name']['oz'] != '')? Yii::$app->request->post('OptionGroupsTranslation')['name']['oz']: $info->name;
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
     * Deletes an existing OptionGroup model.
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
     * Finds the OptionGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OptionGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OptionGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
