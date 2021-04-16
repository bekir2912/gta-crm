<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;
use common\models\Language;
use yii\bootstrap\Widget;

class WLanguage extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('language/view', [
            'current' => Language::getCurrent(),
            'langs' => Language::find()->where('id != :current_id AND `status` = 1', [':current_id' => Language::getCurrent()->id])->orderBy('order')->all(),
        ]);
    }
}