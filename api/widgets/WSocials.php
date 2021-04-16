<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;
use common\models\Social;
use yii\bootstrap\Widget;

class WSocials extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('socials/view', [
            'socials' => Social::find()->where(['status' => 1])->orderBy('order')->all()
        ]);
    }
}