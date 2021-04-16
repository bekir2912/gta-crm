<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;

use common\models\News;
use yii\bootstrap\Widget;

class WNews extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('news/view', [
            'news' => News::find()->where(['status' => 1])->orderBy('`created_at` DESC')->limit(4)->all()
        ]);
    }
}