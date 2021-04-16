<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;

use common\models\Brand;
use yii\bootstrap\Widget;

class WBrand extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('brand/view', [
            'brands' => Brand::find()->where(['status' => 1, 'on_main' => 1])->groupBy('`name`')->orderBy('`order` ASC')->all()
        ]);
    }
}