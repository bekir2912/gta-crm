<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 11.10.2017
 * Time: 4:28
 */

namespace api\controllers;

use common\models\Radar;
use Yii;

class MapController extends \yii\web\Controller
{

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionRadar()
    {
        $city_id = Yii::$app->request->get('city_id') != ''? Yii::$app->request->get('city_id'): null;

        $radars = Radar::find();

        if($city_id) {
            $radars->where(['city_id' => $city_id]);
        }

        return $this->asJson([
            'data' => $radars->all(),
        ]);
    }
}