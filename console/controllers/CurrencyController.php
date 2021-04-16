<?php
namespace console\controllers;

use Yii;

class CurrencyController extends \yii\console\Controller
{
    // Команда "yii example/create test" вызовет "actionCreate('test')"
    public function actionUpdateCurrency()
    {
        $data = $this->loadData('http://cbu.uz/uzc/arkhiv-kursov-valyut/xml/usd/'.date('Y-m-d').'/');
        file_put_contents((__DIR__).'/../../common/config/currency', $data[0]['rate']);
        Yii::$app->params['currency'] = $data[0]['rate'];
        $this->actionUpdateProducts();
    }

    // Команда "yii example/index city" вызовет "actionIndex('city', 'name')"
    // Команда "yii example/index city id" вызовет "actionIndex('city', 'id')"
    public function actionUpdateProducts()
    {
        $products = \common\models\Product::find()->all();
        foreach ($products as $product) {
            if($product->currency != 'uzs' && $product->currency != 'usd') {
                $product->currency = 'uzs';
            }
            if($product->currency == 'uzs') {
                $product->price_usd = round($product->price / Yii::$app->params['currency']);
                $wholesales = [];
                $wholesale = json_decode($product->wholesale, true);
                if(is_array($wholesale)) {
                    foreach ($wholesale as $cnt => $item) {
                        $wholesales[$cnt] = round($item / Yii::$app->params['currency']);
                    }
                }
                $product->wholesale_usd = json_encode($wholesales);
            } else if($product->currency == 'usd') {
                $product->price = round($product->price_usd * Yii::$app->params['currency']);
                $wholesales = [];
                $wholesale = json_decode($product->wholesale_usd, true);
                if(is_array($wholesale)) {
                    foreach ($wholesale as $cnt => $item) {
                        $wholesales[$cnt] = round($item * Yii::$app->params['currency']);
                    }
                }
                $product->wholesale = json_encode($wholesales);
            }
            $product->save();
        }
    }

    protected function loadData($url)
    {
        $data = @file_get_contents($url);

        if (!$data) {
            $this->error = 'Http error';
            return false;
        }

        return $this->transformResponse($data);
    }
    protected function transformResponse($resonse)
    {
        if (!$resonse = @simplexml_load_string($resonse)) {
            $this->error = 'Xml parsing error';
            return false;
        }

        $currencies = [];

        foreach ($resonse->CcyNtry as $key => $value) {
            $currencies[] = [
                'code' => $value->Ccy->__toString(),
                'name_ru' => $value->CcyNm_RU->__toString(),
                'name_uz' => $value->CcyNm_UZ->__toString(),
                'name_uz_cyr' => $value->CcyNm_UZC->__toString(),
                'name_en' => $value->CcyNm_EN->__toString(),
                'decimal_places' => $value->CcyMnrUnts->__toString(),
                'nominal' => $value->Nominal->__toString(),
                'rate' => $value->Rate->__toString(),
                'date' => $value->date->__toString(),
            ];
        }

        return $currencies;
    }

}