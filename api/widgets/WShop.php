<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;

use common\models\Shop;
use yii\bootstrap\Widget;

class WShop extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('shop/view', [
            'shops' => Shop::find()->where(['status' => 1, 'on_main' => 1])->orderBy('`top_order` ASC')->all()
        ]);
    }
}