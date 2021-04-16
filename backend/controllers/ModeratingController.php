<?php

namespace backend\controllers;

use common\components\Helper;
use common\components\SimpleImage;
use common\models\Brand;
use common\models\Category;
use common\models\Lineup;
use common\models\ProductImages;
use common\models\ProductOption;
use common\models\ProductPerformance;
use common\models\ProductPerformanceTranslation;
use common\models\ProductTranslation;
use common\models\Shop;
use common\models\User;
use rmrevin\yii\fontawesome\FA;
use Yii;
use common\models\Product;
use backend\models\ProductSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ModeratingController extends BehaviorsController
{


    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//
//    /**
//     * Displays a single Product model.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }


    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->in_order == 1 && $model->status != -1) {
            $model->status = 2;
        }
        $old_cat = $model->category_id;
        $unset_opt = false;
        $status = $model->status;
        $category = !empty(Yii::$app->request->get('category'))? Yii::$app->request->get('category'): false;

        if(empty($category = Category::findOne(['id' => $category]))) $category = false;
        if(!empty($category)) if(!empty($category->activeCategories))  $category = false;

        if($category) {
            $all_brands = Brand::find()->where(['status' => 1, 'category_id' => $category->id])->all();
            $brand = false;
            if(!empty($all_brands)) {
                $brand = !empty(Yii::$app->request->get('brand'))? Yii::$app->request->get('brand'): false;

                if(empty($brand = Brand::findOne(['id' => $brand, 'status' => 1]))) $brand = false;
            }
            $lineup = false;
            if($brand) {
                $all_lineups = Lineup::find()->where(['status' => 1, 'brand_id' => $brand->id])->all();
                if(!empty($all_lineups)) {
                    $lineup = !empty(Yii::$app->request->get('lineup'))? Yii::$app->request->get('lineup'): false;

                    if(empty($lineup = Lineup::findOne(['id' => $lineup, 'status' => 1]))) $lineup = false;
                }
            }
        }

        $info = ProductTranslation::findOne((['product_id' => $model->id, 'local' => 'ru-RU']));
        $info->scenario = 'create';

        if($category->id == 1 && (isset($brand) && $brand) && (isset($lineup) && $lineup)) {
            $info->name = "-=GTA=-";
        }

        $info_uz = ProductTranslation::findOne((['product_id' => $model->id, 'local' => 'uz-UZ']));
        if(!$info_uz) $info_uz = new ProductTranslation();
        $info_en = ProductTranslation::findOne((['product_id' => $model->id, 'local' => 'en-EN']));
        if(!$info_en) $info_en = new ProductTranslation();
        $info_oz = ProductTranslation::findOne((['product_id' => $model->id, 'local' => 'oz-OZ']));
        if(!$info_oz) $info_oz = new ProductTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->price = isset(Yii::$app->request->post('Product')['price'])? Yii::$app->request->post('Product')['price']: $model->price;
            $model->km = isset(Yii::$app->request->post('Product')['km'])? Yii::$app->request->post('Product')['km']: $model->km;

            $model->price = str_replace(' ', '', $model->price);
            $model->km = str_replace(' ', '', $model->km);
            $model->km = $model->km < 0? 0: $model->km;

            if(Yii::$app->request->post('Product')['category_id'] != $old_cat) $unset_opt = true;
            $model->sale_id = ($model->sale_id > 0)? $model->sale_id: null ;
            if($model->status == 2) {
                $model->in_order = 1;
                $model->status = 1;
            }
            else {
                $model->in_order = 0;
            }
            if (!empty($def_price = Yii::$app->request->post('def_price')) && $def_price == 1) {
                $model->wholesale = json_encode([]);
                $model->price = 0;
                $model->price_usd = 0;
                $model->wholesale_usd = 0;
            } else {
                if ($model->price_type == 0) {
                    $model->wholesale = json_encode([]);
                    $model->wholesale_usd = json_encode([]);

                    if($model->currency == 'uzs') {
                        $model->price_usd = round($model->price / Yii::$app->params['currency']);
                    } else if($model->currency == 'usd'){
                        $model->price_usd = $model->price;
                        $model->price = round($model->price * Yii::$app->params['currency']);
                    }
                }
                if ($model->price_type == 1) {
                    $model->price = 0;
                    $model->price_usd = 0;
                    $wholesale = $model->wholesale;
                    $wholesales = [];
                    $wholesales_usd = [];
                    if (!empty($wholesale)) {
                        foreach ($wholesale['price'] as $it => $item) {
                            if ($item !== '' && $wholesale['count'][$it] !== '') {
                                if($model->currency == 'uzs') {
                                    $wholesales[$wholesale['count'][$it]] = $item;
                                    $wholesales_usd[$wholesale['count'][$it]] = round($item / Yii::$app->params['currency']);
                                } else if($model->currency == 'usd'){
                                    $wholesales_usd[$wholesale['count'][$it]] = $item;
                                    $wholesales[$wholesale['count'][$it]] = round($item * Yii::$app->params['currency']);
                                }
                            }
                        }
                    }
                    ksort($wholesales);
                    ksort($wholesales_usd);
                    $model->wholesale = json_encode($wholesales);
                    $model->wholesale_usd = json_encode($wholesales_usd);
                }
                if ($model->price_type == 2) {

                    if($model->currency == 'uzs') {
                        $model->price_usd = round($model->price / Yii::$app->params['currency']);
                    } else if($model->currency == 'usd'){
                        $model->price_usd = $model->price;
                        $model->price = round($model->price * Yii::$app->params['currency']);
                    }

                    $wholesale = $model->wholesale;
                    $wholesales = [];
                    $wholesales_usd = [];
                    if (!empty($wholesale)) {
                        foreach ($wholesale['price'] as $it => $item) {
                            if ($item !== '' && $wholesale['count'][$it] !== '') {
                                if($model->currency == 'uzs') {
                                    $wholesales[$wholesale['count'][$it]] = $item;
                                    $wholesales_usd[$wholesale['count'][$it]] = round($item / Yii::$app->params['currency']);
                                } else if($model->currency == 'usd'){
                                    $wholesales_usd[$wholesale['count'][$it]] = $item;
                                    $wholesales[$wholesale['count'][$it]] = round($item * Yii::$app->params['currency']);
                                }
                            }
                        }
                    }
                    ksort($wholesales);
                    ksort($wholesales_usd);
                    $model->wholesale = json_encode($wholesales);
                    $model->wholesale_usd = json_encode($wholesales_usd);
                }
            }
            $model->wholesale_unit_id = 0;
            if($status == -1) $model->status = -1;

            $cats = !empty(Yii::$app->request->post('add_cats'))? Yii::$app->request->post('add_cats'): [];
            $model->add_cats = ','.implode(',', array_values(array_unique($cats))).',';
            $model->add_cats_titles = json_encode(Yii::$app->request->post('add_cats_titles'));
            $model->is_moderated = 1;
            if($model->save()) {
                $info->product_id = $model->id;

                if($category->id == 1 && (isset($brand) && $brand) && (isset($lineup) && $lineup)) {
                    $info->name = $brand->name.' '.$lineup->translate->name;
                } else {
                    $info->name = (Yii::$app->request->post('ProductTranslation')['name']['ru'] != '')? Yii::$app->request->post('ProductTranslation')['name']['ru']: $category->translate->name;
                }

                $info->description = (Yii::$app->request->post('ProductTranslation')['description']['ru'] != '')? Yii::$app->request->post('ProductTranslation')['description']['ru']: '';
                $info->warranty = (Yii::$app->request->post('ProductTranslation')['warranty']['ru'] != '')? Yii::$app->request->post('ProductTranslation')['warranty']['ru']: '';
                $info->delivery = (Yii::$app->request->post('ProductTranslation')['delivery']['ru'] != '')? Yii::$app->request->post('ProductTranslation')['delivery']['ru']: '';
                $info->local = 'ru-RU';
                $info->save();

                $info_uz->product_id = $model->id;
                $info_uz->name = (Yii::$app->request->post('ProductTranslation')['name']['uz'] != '')? Yii::$app->request->post('ProductTranslation')['name']['uz']: $info->name;
                $info_uz->description = (Yii::$app->request->post('ProductTranslation')['description']['uz'] != '')? Yii::$app->request->post('ProductTranslation')['description']['uz']: $info->description;
                $info_uz->warranty = (Yii::$app->request->post('ProductTranslation')['warranty']['uz'] != '')? Yii::$app->request->post('ProductTranslation')['warranty']['uz']: $info->warranty;
                $info_uz->delivery = (Yii::$app->request->post('ProductTranslation')['delivery']['uz'] != '')? Yii::$app->request->post('ProductTranslation')['delivery']['uz']: $info->delivery;
                $info_uz->local = 'uz-UZ';
                $info_uz->save();


                $info_en->product_id = $model->id;
                $info_en->name = (Yii::$app->request->post('ProductTranslation')['name']['en'] != '')? Yii::$app->request->post('ProductTranslation')['name']['en']: $info->name;
                $info_en->description = (Yii::$app->request->post('ProductTranslation')['description']['en'] != '')? Yii::$app->request->post('ProductTranslation')['description']['en']: $info->description;
                $info_en->warranty = (Yii::$app->request->post('ProductTranslation')['warranty']['en'] != '')? Yii::$app->request->post('ProductTranslation')['warranty']['en']: $info->warranty;
                $info_en->delivery = (Yii::$app->request->post('ProductTranslation')['delivery']['en'] != '')? Yii::$app->request->post('ProductTranslation')['delivery']['en']: $info->delivery;
                $info_en->local = 'en-EN';
                $info_en->save();

                $info_oz->product_id = $model->id;
                $info_oz->name = (Yii::$app->request->post('ProductTranslation')['name']['oz'] != '')? Yii::$app->request->post('ProductTranslation')['name']['oz']: $info->name;
                $info_oz->description = (Yii::$app->request->post('ProductTranslation')['description']['oz'] != '')? Yii::$app->request->post('ProductTranslation')['description']['oz']: $info->description;
                $info_oz->warranty = (Yii::$app->request->post('ProductTranslation')['warranty']['oz'] != '')? Yii::$app->request->post('ProductTranslation')['warranty']['oz']: $info->warranty;
                $info_oz->delivery = (Yii::$app->request->post('ProductTranslation')['delivery']['oz'] != '')? Yii::$app->request->post('ProductTranslation')['delivery']['oz']: $info->delivery;
                $info_oz->local = 'oz-OZ';
                $info_oz->save();

                $model->url = Helper::toLatin($info->name).'_'.$model->id;
                $model->save();

                $image = UploadedFile::getInstanceByName('mainImage');
                $dir = (__DIR__).'/../../uploads/products/';
                if($image){
                    $old_image = ProductImages::findOne(['main' => 1, 'product_id' => $model->id]);
                    if(!empty($old_image)) $old_image->delete();
                    $image_model = new ProductImages();
                    $image_model->product_id = $model->id;
                    $image_model->main = 1;
                    $path = $image->baseName.'.'.$image->extension;
                    if($image->saveAs($dir.$path)) {
                        $resizer = new SimpleImage();
                        $resizer->load($dir.$path);
                        if($category->on_main == 1) {
                            $resizer->resize(Yii::$app->params['imageSizes']['services']['image'][0], Yii::$app->params['imageSizes']['services']['image'][1]);
                        } else {
                            $resizer->resize(Yii::$app->params['imageSizes']['products']['image'][0], Yii::$app->params['imageSizes']['products']['image'][1]);
                        }
                        $image_name = uniqid().'.'.$image->extension;
                        $resizer->save($dir.$image_name);
                        $image_model->image = '/uploads/products/'.$image_name;
                        if(file_exists($dir.$path)) unlink($dir.$path);

                        $image_model->save();
                    }
                    else {
                        Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                        return $this->goBack();
                    }
                }

                $images = UploadedFile::getInstancesByName('images');
                if(!empty($images)) {
                    foreach ($images as $image) {
                        $image_model = new ProductImages();
                        $image_model->product_id = $model->id;
                        $image_model->main = 0;
                        $path = $image->baseName.'.'.$image->extension;
                        if($image->saveAs($dir.$path)) {
                            $resizer = new SimpleImage();
                            $resizer->load($dir.$path);
                            $resizer->resize(Yii::$app->params['imageSizes']['products']['image'][0], Yii::$app->params['imageSizes']['products']['image'][1]);
                            $image_name = uniqid().'.'.$image->extension;
                            $resizer->save($dir.$image_name);
                            $image_model->image = '/uploads/products/'.$image_name;
                            if(file_exists($dir.$path)) unlink($dir.$path);

                            $image_model->save();
                        }
                        else {
                            Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                            return $this->goBack();
                        }
                    }

                }
                if($unset_opt) {
//                    ProductOption::deleteAll(['product_id' => $model->id]);
                }

                ProductOption::deleteAll(['product_id' => $model->id]);

                $model_custom_options = [];
                $custom_options = Yii::$app->request->post('custom_options', []);
                if (!empty($options = Yii::$app->request->post('options'))) {
                    foreach ($options as $group_id => $option) {
                        if (!isset($option['id'])) continue;
                        if ($option['id'] == -1) {
                            $model_custom_options[$group_id] = isset($custom_options[$group_id])? $custom_options[$group_id]: '';
                            continue;
                        }
                        $opt = new ProductOption();
                        $opt->product_id = $model->id;
                        $opt->option_id = $option['id'];
                        $opt->price = 0;
                        $opt->save();
                    }
                }
                ProductPerformance::deleteAll(['product_id' => $model->id]);
                if(!empty($performances = Yii::$app->request->post('Preformance'))) {
                    foreach ($performances['ru']['name'] as $ind => $name) {
                        if(trim($name) == '' && trim($performances['ru']['desc'][$ind]) == '') continue;
                        $perf = new ProductPerformance();
                        $perf->product_id = $model->id;
                        $perf->save();
                        $perf_ru = new ProductPerformanceTranslation();
                        $perf_uz = new ProductPerformanceTranslation();
                        $perf_en = new ProductPerformanceTranslation();
                        $perf_ru->product_performance_id = $perf->id;
                        $perf_ru->name = $name;
                        $perf_ru->description = $performances['ru']['desc'][$ind];
                        $perf_ru->local = 'ru-RU';
                        $perf_ru->save();
                        $perf_uz->product_performance_id = $perf->id;
                        $perf_uz->name = ($performances['uz']['name'][$ind])? $performances['uz']['name'][$ind]: $name;
                        $perf_uz->description = ($performances['uz']['desc'][$ind])? $performances['uz']['desc'][$ind]: $performances['ru']['desc'][$ind];
                        $perf_uz->local = 'uz-UZ';
                        $perf_uz->save();
                        $perf_en->product_performance_id = $perf->id;
                        $perf_en->name = ($performances['en']['name'][$ind])? $performances['en']['name'][$ind]: $name;
                        $perf_en->description = ($performances['en']['desc'][$ind])? $performances['en']['desc'][$ind]: $performances['ru']['desc'][$ind];
                        $perf_en->local = 'en-EN';
                        $perf_en->save();
                    }
                }
                return $this->redirect(['update', 'id' => $model->id, 'category' => $model->category_id, 'brand' => $model->brand_id, 'lineup' => $model->lineup_id]);
            }
            else {
                Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                return $this->goBack();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'category' => $category,
                'brand' => $brand,
                'lineup' => $lineup,
                'info' => $info,
                'info_uz' => $info_uz,
                'info_oz' => $info_oz,
                'info_en' => $info_en,
            ]);
        }
    }

    public function actionDeleteImage() {
        if(!empty($prod_id = Yii::$app->request->get('product_id')) &&
            !empty($image = Yii::$app->request->get('image_id'))) {
            $item = ProductImages::findOne(['id' => $image, 'product_id' => $prod_id]);
            if(empty($item)) return json_encode(['error' => 'empty-item']);
            if($item->main == 1) return json_encode(['error' => 'item-isMain']);
            $item->delete();
            return json_encode(['error' => false]);
        }
        return json_encode(['error' => true]);
    }
    public function actionBlock() {

        $model = $this->findModel(Yii::$app->request->post('id'));
//        if($model->status != -1) {
        $model->is_moderated = 1;
        $model->status = Yii::$app->request->post('status');
        $model->save();
//        }
        return $this->redirect(['update', 'id' => $model->id, 'category' => $model->category_id, 'brand' => $model->brand_id, 'lineup' => $model->lineup_id]);
    }
    public function actionDelete($id)
    {
        $product = $this->findModel($id);
        $product->delete();
        return $this->redirect(['index']);
    }
//
//    /**
//     * Deletes an existing Product model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id, 'deleted_at' => 0])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
