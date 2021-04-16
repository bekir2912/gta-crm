<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;
use common\models\StaticPageCategory;
use yii\bootstrap\Widget;

class WStaticPage extends Widget
{
    public $key;
    public function init(){}

    public function run() {
        if($this->key == 'info') {
            return $this->render('static-page/view', [
                'static_page_cats' => StaticPageCategory::findAll(['id' => 1])
            ]);
        }
        if($this->key == 'copy') {
            return $this->render('static-page/copy', [
                'static_page_cats' => StaticPageCategory::findAll(['id' => 2])
            ]);
        }
    }
}