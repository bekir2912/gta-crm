<?php

use yii\db\Migration;

class m180312_104758_restore_delete_rows extends Migration
{
    public function safeUp()
    {
        \common\models\BannerTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\CategoryTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\CityTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\NewsTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\OptionGroupsTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\OptionValuesTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\ProductPerformanceTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\ProductTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\ShopAddresses::deleteAll(['local' => 'uz-UZ']);
        \common\models\ShopDeliveryTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\StaticPageCategoryTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\StaticPageTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\UnitTranslation::deleteAll(['local' => 'uz-UZ']);

        $banners = \common\models\BannerTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($banners)) {
            foreach ($banners as $data) {
                $copy = new \common\models\BannerTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'banners_restored';
        }
        $cats = \common\models\CategoryTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($cats)) {
            foreach ($cats as $data) {
                $copy = new \common\models\CategoryTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'cats_restored';
        }
        $cities = \common\models\CityTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($cities)) {
            foreach ($cities as $data) {
                $copy = new \common\models\CityTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'cities_restored';
        }
        $news = \common\models\NewsTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($news)) {
            foreach ($news as $data) {
                $copy = new \common\models\NewsTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'news_restored';
        }
        $og = \common\models\OptionGroupsTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($og)) {
            foreach ($og as $data) {
                $copy = new \common\models\OptionGroupsTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'og_restored';
        }
        $ov = \common\models\OptionValuesTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($ov)) {
            foreach ($ov as $data) {
                $copy = new \common\models\OptionValuesTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'ov_restored';
        }
        $prod_perf = \common\models\ProductPerformanceTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($prod_perf)) {
            foreach ($prod_perf as $data) {
                $copy = new \common\models\ProductPerformanceTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'prod_perf_restored';
        }
        $prod = \common\models\ProductTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($prod)) {
            foreach ($prod as $data) {
                $copy = new \common\models\ProductTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'prod_restored';
        }
        $shops = \common\models\ShopAddresses::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($shops)) {
            foreach ($shops as $data) {
                $copy = new \common\models\ShopAddresses();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'shops_restored';
        }
        $del = \common\models\ShopDeliveryTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($del)) {
            foreach ($del as $data) {
                $copy = new \common\models\ShopDeliveryTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'del_restored';
        }
        $sp_cats = \common\models\StaticPageCategoryTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($sp_cats)) {
            foreach ($sp_cats as $data) {
                $copy = new \common\models\StaticPageCategoryTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'sp_cats_restored';
        }
        $sp = \common\models\StaticPageTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($sp)) {
            foreach ($sp as $data) {
                $copy = new \common\models\StaticPageTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'sp_restored';
        }
        $units = \common\models\UnitTranslation::find()->where(['local' => 'ru-RU'])->all();
        if(!empty($units)) {
            foreach ($units as $data) {
                $copy = new \common\models\UnitTranslation();
                $copy->setAttributes($data->getAttributes());
                $copy->id = null;
                $copy->local = 'uz-UZ';
                $copy->save();
                unset($copy);
            }
            echo 'units_restored';
        }
//        banner_translations   +
//        category_translations +
//        city_translations +
//        news_translations  +
//        option_groups_translations    +
//        option_values_translations    +
//        product_performance_translations  +
//        product_translations  +
//        shop_addresses    +
//        shop_delivery_translations    +
//        static_page_category_translations +
//        static_page_translations +
//        unit_translations
    }

    public function safeDown()
    {
        \common\models\BannerTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\CategoryTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\CityTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\NewsTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\OptionGroupsTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\OptionValuesTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\ProductPerformanceTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\ProductTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\ShopAddresses::deleteAll(['local' => 'uz-UZ']);
        \common\models\ShopDeliveryTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\StaticPageCategoryTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\StaticPageTranslation::deleteAll(['local' => 'uz-UZ']);
        \common\models\UnitTranslation::deleteAll(['local' => 'uz-UZ']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180312_104758_restore_delete_rows cannot be reverted.\n";

        return false;
    }
    */
}
