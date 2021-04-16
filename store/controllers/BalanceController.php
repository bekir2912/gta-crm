<?php

namespace store\controllers;

use common\components\Helper;
use common\components\SimpleImage;
use common\models\Brand;
use common\models\Category;
use common\models\Lineup;
use common\models\ProductImages;
use common\models\ProductOption;
use common\models\ProductPerformance;
use common\models\ProductPerformanceTranslation;
use common\models\ProductTranslation;
use common\models\Shop;
use rmrevin\yii\fontawesome\FA;
use Yii;
use common\models\Product;
use store\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class BalanceController extends BehaviorsController
{
    public function actionFill() {
        return $this->render('fill', [

        ]);
    }
}
