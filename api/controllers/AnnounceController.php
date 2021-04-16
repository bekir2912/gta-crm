<?php

namespace api\controllers;

use api\transformers\AnnounceList;
use common\models\OptionGroup;
use common\models\OptionValue;
use common\models\Product;
use common\models\Shop;
use common\models\User;
use Yii;

class AnnounceController extends \yii\web\Controller
{

    public function actionIndex($id)
    {
        $product = Product::findOne(['status' => 1, 'id' => $id]);
        if (empty($product)) return $this->redirect(['site/error', 'message' => 'Not Found', 'code' => 404]);
        if ($product->shop_id && $product->shop->status != 1) return $this->redirect(['site/error', 'message' => 'Not Found', 'code' => 404]);
        if ($product->user && $product->user->status != 10) return $this->redirect(['site/error', 'message' => 'Not Found', 'code' => 404]);
        if ($product->category->on_main == 1) return $this->redirect(['site/error', 'message' => 'Not Found', 'code' => 404]);

        $unset = false;
        $temp_parent = $product->category;
        while ($temp_parent) {
            if (!$temp_parent->status) {
                $unset = true;
                break;
            }
            if (empty($temp_parent->parent)) {
                break;
            }
            $temp_parent = $temp_parent->parent;
        }

        if ($unset) return $this->redirect(['site/error', 'message' => 'Not Found', 'code' => 404]);

//        $category_views = (!empty(Yii::$app->session->get('category_views')))? Yii::$app->session->get('category_views'): [];
//        if(!in_array($temp_parent->id, $category_views)) {
//            $category_views[] = $temp_parent->id;
//            Yii::$app->session->set('category_views', $category_views);
//            $temp_parent->view++;
//            $temp_parent->save();
//        }

        $options = [];
        for ($k = 0; $k < count($product->activeOptions); $k++) {
            $opt = OptionValue::findOne(['id' => $product->activeOptions[$k]->option_id, 'status' => 1]);
            $opt_ids[] = $opt->id;
            if (empty($options['group'][$opt->group_id])) $options['group'][$opt->group_id] = OptionGroup::findOne(['id' => $opt->group_id, 'status' => 1]);
            if (empty($options['values'][$opt->group_id][$opt->id])) $options['values'][$opt->group_id][$opt->id] = $opt;
            if (empty($options['prices'][$opt->group_id][$opt->id])) $options['prices'][$opt->group_id][$opt->id] = $product->activeOptions[$k]->price;
        }
//        if(Yii::$app->user->id) {
//            if(empty(UserRecent::findOne(['user_id' => Yii::$app->user->id, 'product_id' => $product->id]))) {
        $product->view++;
                if ($product->shop_id) {
        $product->shop->view_prods++;
        $product->shop->save();
                }
//            }
//            UserRecent::addProduct($product->id);
//        }
//        else {
//            $prod_ids = (!empty(Yii::$app->session->get('product_fav_ids')))? Yii::$app->session->get('product_fav_ids'): [];
//            if(!in_array($product->id, $prod_ids)) {
//                $product->view++;
//                if ($product->shop_id) {
//                    $product->shop->view_prods++;
//                    $product->shop->save();
//                }
//            }
//            if(($key = array_search($product->id, $prod_ids)) !== false) {
//                unset($prod_ids[$key]);
//            }
////            if(count($prod_ids) >= Yii::$app->params['recent_count']) {
////                unset($prod_ids[array_keys($prod_ids)[0]]);
////            }
//            $prod_ids[] = $product->id;
//            Yii::$app->session['product_fav_ids'] = array_values($prod_ids);
//        }
        $product->save();
        $currency = Yii::$app->request->get('currency', 'uzs');
        if ($currency == 'usd') {
            $product->price = $product->price_usd;
            $product->wholesale = $product->wholesale_usd;
        }

        return $this->asJson(['data' => AnnounceList::transform([$product], $currency)]);
//        return $this->render('index', [
//            'product' => $product,
//            'category_spec' => $temp_parent->spec,
//            'options' => $options,
//            'reviews' => OrderProduct::find()->where(['comment_status' => 1, 'product_id' => $product->id])->all(),
//        ]);
    }


    public function actionShowNumber()
    {
        $id = !empty(Yii::$app->request->get('id')) ? Yii::$app->request->get('id') : false;
        if (!$id) {
            return $this->asJson(['phones' => null]);
        }
        $product = Product::findOne(['id' => $id, 'status' => 1]);
        if ($product) {
            if ($product->shop_id) {
                $shop = Shop::findOne(['id' => $product->shop_id, 'status' => 1]);
                if (empty($shop)) {
                    return $this->asJson(['phones' => null]);
                }
                $shop->info->phone = explode('; ', $shop->info->phone);


                if (!empty($shop->info->phone)) {
//                    $shop_phones = (!empty(Yii::$app->session->get('shop_phones'))) ? Yii::$app->session->get('shop_phones') : [];
//                    if (!in_array($shop->id, $shop_phones)) {
//                        $shop_phones[] = $shop->id;
//                        Yii::$app->session->set('shop_phones', $shop_phones);
                    $shop->view_phone++;
                    $shop->save();
//                    }
//                    $product_phones = (!empty(Yii::$app->session->get('prod_phones'))) ? Yii::$app->session->get('prod_phones') : [];
//                    if (!in_array($product->id, $product_phones)) {
//                        $product_phones[] = $product->id;
//                        Yii::$app->session->set('prod_phones', $product_phones);
                    $product->phone_views++;
                    $product->save();
//                    }
                    return $this->asJson(['phones' => $shop->info->phone]);
                }
            } elseif ($product->user_id) {
                $user = User::findOne(['id' => $product->user_id, 'status' => 10]);
                if (empty($user)) {
                    return $this->asJson(['phones' => null]);
                }

                if ($user->phone != '') {
                    $product_phones = (!empty(Yii::$app->session->get('prod_phones'))) ? Yii::$app->session->get('prod_phones') : [];
//                    if (!in_array($product->id, $product_phones)) {
//                        $product_phones[] = $product->id;
//                        Yii::$app->session->set('prod_phones', $product_phones);
                    $product->phone_views++;
                    $product->save();
//                    }
                    return $this->asJson(['phones' => [$user->phone]]);
                }
            }
        }

        return $this->asJson(['phones' => null]);
    }

}