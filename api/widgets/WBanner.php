<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;
use common\models\Banner;
use yii\bootstrap\Widget;

class WBanner extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('banner/view', [
            'banners' => Banner::find()->where(['status' => 1])->orderBy('order')->all()
        ]);
    }
}