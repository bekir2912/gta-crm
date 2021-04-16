<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;
use common\models\Category;
use common\models\Language;
use Yii;
use yii\bootstrap\Widget;

class WCategory extends Widget
{
    public $key;
    public $tab;
    public function init(){}

    public function run() {
        if($this->key == 'menu') {
            return $this->render('category/view', [
                'current' => Language::getCurrent(),
                'langs' => Language::find()->where('id != :current_id AND `status` = 1', [':current_id' => Language::getCurrent()->id])->orderBy('order')->all(),
                'menu' => Category::find()->where(['status' => 1, 'parent_id' => null])->orderBy('order')->all()
            ]);
        }
        if($this->key == 'footer') {
            return $this->render('category/footer', [
                'menu' => Category::find()->where(['status' => 1, 'parent_id' => null])->orderBy('order')->all()
            ]);
        }
    }
}