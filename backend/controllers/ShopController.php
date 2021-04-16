<?php

namespace backend\controllers;

use common\components\Helper;
use common\components\SimpleImage;
use common\models\ShopAddresses;
use rmrevin\yii\fontawesome\FA;
use Yii;
use common\models\Shop;
use backend\models\ShopSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ShopController extends BehaviorsController
{

    /**
     * Lists all Shop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * Displays a single Shop model.
//     * @param integer $id
//     * @return mixed
//     */
    public function actionCreate()
    {
        $model = new Shop(['scenario' => 'create']);
        $info = new ShopAddresses(['scenario' => 'create']);
        $info_uz = new ShopAddresses();
        $info_en = new ShopAddresses();
        $info_oz = new ShopAddresses();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $phones = Yii::$app->request->post('phones', []);
            $phones = implode('; ', array_filter($phones));
            if($model->order == '') $model->order = 0;
            if($model->service == '') $model->service = 0;
            if($model->top_order == '') $model->top_order = 0;
            $image = UploadedFile::getInstance($model,'image');
            $logo = UploadedFile::getInstance($model,'logo');
            $cert = UploadedFile::getInstance($model,'certificate');
            $licence = UploadedFile::getInstance($model,'licence');
//            if(!$image || !$logo) {
//                Yii::$app->session->setFlash('error', FA::i('warning').' Фото и Лого обязательны');
//                return $this->render('create', [
//                    'model' => $model,
//                    'info' => $info,
//                    'info_uz' => $info_uz,
//                    'info_en' => $info_en,
//                ]);
//            }
            $dir = (__DIR__).'/../../uploads/shops/';
            if($image){
                $path = $image->baseName.'.'.$image->extension;
                if($image->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['shops']['image'][0], Yii::$app->params['imageSizes']['shops']['image'][1]);
                    $image_name = uniqid().'.'.$image->extension;
                    $resizer->save($dir.$image_name);
                    $model->image = '/uploads/shops/'.$image_name;
                    if(is_file($dir.$path)) if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else $model->image = '/uploads/site/default_shop-image.png';
            if($cert){
                $path = $cert->baseName.'.'.$cert->extension;
                if($cert->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['shops']['image'][0], Yii::$app->params['imageSizes']['shops']['image'][1]);
                    $cert_name = uniqid().'.'.$cert->extension;
                    $resizer->save($dir.$cert_name);
                    $model->certificate = '/uploads/shops/'.$cert_name;
                    if(is_file($dir.$path)) if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            if($licence){
                $path = $licence->baseName.'.'.$licence->extension;
                if($licence->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
//                    $resizer->resize(Yii::$app->params['imageSizes']['shops']['image'][0], Yii::$app->params['imageSizes']['shops']['image'][1]);
                    $licence_name = uniqid().'.'.$licence->extension;
                    $resizer->save($dir.$licence_name);
                    $model->licence = '/uploads/shops/'.$licence_name;
                    if(is_file($dir.$path)) if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            if($logo){
                $path = $logo->baseName.'.'.$logo->extension;
                if($logo->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['shops']['logo'][0], Yii::$app->params['imageSizes']['shops']['logo'][1]);
                    $logo_name = uniqid().'.'.$logo->extension;
                    $resizer->save($dir.$logo_name);
                    $model->logo = '/uploads/shops/'.$logo_name;
                    if(is_file($dir.$path)) if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else $model->logo = '/uploads/site/default_shop.png';
//            $model->seller_id = Yii::$app->user->id;

            $payments = Yii::$app->request->post('payments');
            $cities = Yii::$app->request->post('cities');
            $model->payments = json_encode($payments);
            $model->cities = json_encode($cities);

            $model->url = '_'.uniqid();

            if($model->save()) $model->url = Helper::toLatin($model->name).'_'.$model->id;
            else {
                Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                return $this->render('create', [
                    'model' => $model,
                    'info' => $info,
                    'info_uz' => $info_uz,
                    'info_oz' => $info_oz,
                    'info_en' => $info_en,
                ]);
            }
            if($model->save()) {
                $info->shop_id = $model->id;
                $info->description = (Yii::$app->request->post('ShopAddresses')['description']['ru'] != '')? Yii::$app->request->post('ShopAddresses')['description']['ru']: '';
                $info->address = (Yii::$app->request->post('ShopAddresses')['address']['ru'] != '')? Yii::$app->request->post('ShopAddresses')['address']['ru']: '';
                $info->lat = (Yii::$app->request->post('ShopAddresses')['lat'])? Yii::$app->request->post('ShopAddresses')['lat']: '';
                $info->lng = (Yii::$app->request->post('ShopAddresses')['lng'])? Yii::$app->request->post('ShopAddresses')['lng']: '';
                $info->phone = $phones;
                $info->email = (Yii::$app->request->post('ShopAddresses')['email'])? Yii::$app->request->post('ShopAddresses')['email']: '';
                $info->local = 'ru-RU';
                $info->schedule = [];
                $days = Yii::$app->request->post('Days', '0');
                $time = Yii::$app->request->post('Time', '0');
                $alltime = Yii::$app->request->post('AllTime', '0');
                $info->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info->save();

                $info_uz->shop_id = $model->id;
                $info_uz->description = (Yii::$app->request->post('ShopAddresses')['description']['uz'] != '')? Yii::$app->request->post('ShopAddresses')['description']['uz']: $info->description;
                $info_uz->address = (Yii::$app->request->post('ShopAddresses')['address']['uz'] != '')? Yii::$app->request->post('ShopAddresses')['address']['uz']: $info->address;
                $info_uz->lat = $info->lat;
                $info_uz->lng = $info->lng;
                $info_uz->phone = $info->phone;
                $info_uz->email = $info->email;
                $info_uz->local = 'uz-UZ';
                $info_uz->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info_uz->save();

                $info_en->shop_id = $model->id;
                $info_en->description = (Yii::$app->request->post('ShopAddresses')['description']['en'] != '')? Yii::$app->request->post('ShopAddresses')['description']['en']: $info->description;
                $info_en->address = (Yii::$app->request->post('ShopAddresses')['address']['en'] != '')? Yii::$app->request->post('ShopAddresses')['address']['en']: $info->address;
                $info_en->lat = $info->lat;
                $info_en->lng = $info->lng;
                $info_en->phone = $info->phone;
                $info_en->email = $info->email;
                $info_en->local = 'en-EN';
                $info_en->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info_en->save();

                $info_oz->shop_id = $model->id;
                $info_oz->description = (Yii::$app->request->post('ShopAddresses')['description']['oz'] != '')? Yii::$app->request->post('ShopAddresses')['description']['oz']: $info->description;
                $info_oz->address = (Yii::$app->request->post('ShopAddresses')['address']['oz'] != '')? Yii::$app->request->post('ShopAddresses')['address']['oz']: $info->address;
                $info_oz->lat = $info->lat;
                $info_oz->lng = $info->lng;
                $info_oz->phone = $info->phone;
                $info_oz->email = $info->email;
                $info_oz->local = 'oz-OZ';
                $info_oz->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info_oz->save();

                Yii::$app->session->set('shop_id', $model->id);
                return $this->redirect(['update', 'id' => $model->id]);
            }
            else {
                Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                return $this->render('create', [
                    'model' => $model,
                    'info' => $info,
                    'info_uz' => $info_uz,
                    'info_oz' => $info_oz,
                    'info_en' => $info_en,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'info' => $info,
                'info_uz' => $info_uz,
                'info_oz' => $info_oz,
                'info_en' => $info_en,
            ]);
        }
    }

    /**
     * Updates an existing Shop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'create';
        $old_img = $model->image;
        $old_logo = $model->logo;
        $old_certificate = $model->certificate;
        $old_licence = $model->licence;
        Yii::$app->session->set('shop_id', $model->id);

        $info = ShopAddresses::findOne(['shop_id' => $model->id, 'local' => 'ru-RU']);
        $info->scenario = 'create';
        $info_uz = ShopAddresses::findOne(['shop_id' => $model->id, 'local' => 'uz-UZ']);
        $info_en = ShopAddresses::findOne(['shop_id' => $model->id, 'local' => 'en-EN']);
        $info_oz = ShopAddresses::findOne(['shop_id' => $model->id, 'local' => 'oz-OZ']);
        if(!$info_oz) $info_oz = new ShopAddresses();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $phones = Yii::$app->request->post('phones', []);
            $phones = implode('; ', array_filter($phones));
            if($model->order == '') $model->order = 0;
            if($model->service == '') $model->service = 0;
            if($model->top_order == '') $model->top_order = 0;
            $image = UploadedFile::getInstance($model,'image');
            $logo = UploadedFile::getInstance($model,'logo');
            $cert = UploadedFile::getInstance($model,'certificate');
            $licence = UploadedFile::getInstance($model,'licence');
            $dir = (__DIR__).'/../../uploads/shops/';
            if($image){
                $path = $image->baseName.'.'.$image->extension;
                if($image->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['shops']['image'][0], Yii::$app->params['imageSizes']['shops']['image'][1]);
                    $image_name = uniqid().'.'.$image->extension;
                    $resizer->save($dir.$image_name);
//                    if(file_exists((__DIR__).'/../..'.$old_img) && $old_img != '/uploads/site/default_shop.png') unlink((__DIR__).'/../..'.$old_img);
                    $model->image = '/uploads/shops/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
                else {
                    Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                    return $this->render('update', [
                        'model' => $model,
                        'info' => $info,
                        'info_uz' => $info_uz,
                        'info_oz' => $info_oz,
                        'info_en' => $info_en,
                    ]);
                }
            }
            else $model->image = $old_img;
            if($logo){
                $path = $logo->baseName.'.'.$logo->extension;
                if($logo->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $resizer->resize(Yii::$app->params['imageSizes']['shops']['logo'][0], Yii::$app->params['imageSizes']['shops']['logo'][1]);
                    $logo_name = uniqid().'.'.$logo->extension;
                    $resizer->save($dir.$logo_name);
//                    if(file_exists((__DIR__).'/../..'.$old_logo) && $old_img != '/uploads/site/default_shop.png') unlink((__DIR__).'/../..'.$old_logo);
                    $model->logo = '/uploads/shops/'.$logo_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
                else {
                    Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                    return $this->render('update', [
                        'model' => $model,
                        'info' => $info,
                        'info_uz' => $info_uz,
                        'info_oz' => $info_oz,
                        'info_en' => $info_en,
                    ]);
                }
            }
            else $model->logo = $old_logo;
            if($cert){
                $path = $cert->baseName.'.'.$cert->extension;
                if($cert->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
//                    $resizer->resize(120, 120);
                    $cert_name = uniqid().'.'.$cert->extension;
                    $resizer->save($dir.$cert_name);
                    if($old_certificate != '') if(file_exists((__DIR__).'/../..'.$old_certificate)) unlink((__DIR__).'/../..'.$old_certificate);
                    $model->certificate = '/uploads/shops/'.$cert_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
            else $model->certificate = $old_certificate;
            if($licence){
                $path = $licence->baseName.'.'.$licence->extension;
                if($licence->saveAs($dir.$path)) {
                    $resizer = new SimpleImage();
                    $resizer->load($dir.$path);
                    $licence_name = uniqid().'.'.$licence->extension;
                    $resizer->save($dir.$licence_name);
                    if($old_licence != '') if(file_exists((__DIR__).'/../..'.$old_licence)) unlink((__DIR__).'/../..'.$old_licence);
                    $model->licence = '/uploads/shops/'.$licence_name;
                    if(is_file($dir.$path)) if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }
//            $model->seller_id = Yii::$app->user->id;

            $payments = Yii::$app->request->post('payments');
            $cities = Yii::$app->request->post('cities');
            $model->payments = json_encode($payments);
            $model->cities = json_encode($cities);

            if($model->save()) $model->url = Helper::toLatin($model->name).'_'.$model->id;
            else {
                Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                return $this->render('update', [
                    'model' => $model,
                    'info' => $info,
                    'info_uz' => $info_uz,
                    'info_oz' => $info_oz,
                    'info_en' => $info_en,
                ]);
            }
            if($model->save()) {
                $info->shop_id = $model->id;
                $info->description = (Yii::$app->request->post('ShopAddresses')['description']['ru'] != '')? Yii::$app->request->post('ShopAddresses')['description']['ru']: '';
                $info->address = (Yii::$app->request->post('ShopAddresses')['address']['ru'] != '')? Yii::$app->request->post('ShopAddresses')['address']['ru']: '';
                $info->lat = (Yii::$app->request->post('ShopAddresses')['lat'])? Yii::$app->request->post('ShopAddresses')['lat']: '';
                $info->lng = (Yii::$app->request->post('ShopAddresses')['lng'])? Yii::$app->request->post('ShopAddresses')['lng']: '';
                $info->phone = $phones;
                $info->email = (Yii::$app->request->post('ShopAddresses')['email'])? Yii::$app->request->post('ShopAddresses')['email']: '';
                $info->local = 'ru-RU';
                $info->schedule = [];
                $days = Yii::$app->request->post('Days', '0');
                $time = Yii::$app->request->post('Time', '0');
                $alltime = Yii::$app->request->post('AllTime', '0');
                $info->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info->save();

                $info_uz->shop_id = $model->id;
                $info_uz->description = (Yii::$app->request->post('ShopAddresses')['description']['uz'] != '')? Yii::$app->request->post('ShopAddresses')['description']['uz']: $info->description;
                $info_uz->address = (Yii::$app->request->post('ShopAddresses')['address']['uz'] != '')? Yii::$app->request->post('ShopAddresses')['address']['uz']: $info->address;
                $info_uz->lat = $info->lat;
                $info_uz->lng = $info->lng;
                $info_uz->phone = $info->phone;
                $info_uz->email = $info->email;
                $info_uz->local = 'uz-UZ';
                $info_uz->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info_uz->save();

                $info_en->shop_id = $model->id;
                $info_en->description = (Yii::$app->request->post('ShopAddresses')['description']['en'] != '')? Yii::$app->request->post('ShopAddresses')['description']['en']: $info->description;
                $info_en->address = (Yii::$app->request->post('ShopAddresses')['address']['en'] != '')? Yii::$app->request->post('ShopAddresses')['address']['en']: $info->address;
                $info_en->lat = $info->lat;
                $info_en->lng = $info->lng;
                $info_en->phone = $info->phone;
                $info_en->email = $info->email;
                $info_en->local = 'en-EN';
                $info_en->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info_en->save();

                $info_oz->shop_id = $model->id;
                $info_oz->description = (Yii::$app->request->post('ShopAddresses')['description']['oz'] != '')? Yii::$app->request->post('ShopAddresses')['description']['oz']: $info->description;
                $info_oz->address = (Yii::$app->request->post('ShopAddresses')['address']['oz'] != '')? Yii::$app->request->post('ShopAddresses')['address']['oz']: $info->address;
                $info_oz->lat = $info->lat;
                $info_oz->lng = $info->lng;
                $info_oz->phone = $info->phone;
                $info_oz->email = $info->email;
                $info_oz->local = 'oz-OZ';
                $info_oz->schedule = json_encode(['days' => $days, 'time' => $time, 'alltime' => $alltime]);
                $info_oz->save();

                Yii::$app->session->set('shop_id', $model->id);
                return $this->redirect(['update', 'id' => $model->id]);
            }
            else {
                Yii::$app->session->setFlash('error', FA::i('warning').' Ошибка, попробуйте позже.');
                return $this->render('update', [
                    'model' => $model,
                    'info' => $info,
                    'info_uz' => $info_uz,
                    'info_oz' => $info_oz,
                    'info_en' => $info_en,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'info' => $info,
                'info_uz' => $info_uz,
                'info_oz' => $info_oz,
                'info_en' => $info_en,
            ]);
        }
    }
    public function actionDelete($id)
    {
        $shop = $this->findModel($id);
        $shop->deleted_at = time();
        $shop->status = -1;
        $shop->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Shop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shop::findOne(['id' => $id, 'deleted_at' => 0])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
