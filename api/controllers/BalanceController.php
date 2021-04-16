<?php

namespace frontend\controllers;


use Yii;
use yii\filters\AccessControl;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class BalanceController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'purchase-delete' => ['post'],
//                ],
//            ],
        ];
    }
    public function actionFill() {

        Yii::$app->session->set('root_category', false);
        Yii::$app->session->set('page', 'cabinet');

        return $this->render('fill', [

        ]);
    }
}
