<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;
use common\models\Brand;
use common\models\Category;
use common\models\Language;
use common\models\Lineup;
use common\models\Product;
use common\models\UserRecent;
use Yii;
use yii\bootstrap\Widget;

class WProduct extends Widget
{
    public $id = false;
    public $cat_id = false;
    public function init(){}

    public function run() {
        $title = false;
        $product = Product::findOne($this->id);
        $query = Product::find()->where(['status' => 1]);
        $query->andWhere(['!=', 'id' , $this->id]);
        if ($this->cat_id) {
            $category = Category::findOne(['id' => $this->cat_id, 'status' => 1]);
            if ($category) {
                if ($product->brand_id) {
                    $brand = Brand::findOne(['category_id' => $category->id, 'name' => $product->brand->name]);
                    if($brand) {
                        if ($product->lineup_id) {
                            $lineup = Lineup::find()
                                ->where(['brand_id' => $brand->id])
                                ->leftJoin('lineup_translations', 'lineup_translations.lineup_id=lineups.id AND lineup_translations.local = "'.Language::getCurrent()->local.'"');
                            $lineup = $lineup->andFilterWhere(['like', 'lineup_translations.name', $product->lineup->translate->name])->one();
                            if($lineup) {
                                $query->andWhere(['lineup_id' => $lineup->id]);
                                $products = $query->limit(16)->orderBy('`view` DESC')->all();
                            } else {
                                $query->andWhere(['brand_id' => $brand->id]);
                                $products = $query->limit(16)->orderBy('`view` DESC')->all();
                            }
                        } else {
                            $query->andWhere(['brand_id' => $brand->id]);
                            $products = $query->limit(16)->orderBy('`view` DESC')->all();
                        }
                    }
                    else {
                        $products = [];
                    }
                } else {
                    $products = [];
                }

                $products = [];
                $title = $category->translate->name;
            } else {
                $products = [];
            }
        } else {
            if ($product->lineup_id) {
                $query->andWhere(['lineup_id' => $product->lineup_id]);
            } else if ($product->brand_id) {
                $query->andWhere(['brand_id' => $product->brand_id]);
            } else {
                $query->andWhere(['category_id' => $product->category_id]);
            }
            $products = $query->limit(16)->orderBy('`view` DESC')->all();
            $title = Yii::t('frontend', 'Similar');
        }

        return $this->render('product/view', [
            'prod_id' => $this->id,
            'products' => $products,
            'title' => $title
        ]);
    }
}