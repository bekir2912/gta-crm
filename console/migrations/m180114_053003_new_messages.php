<?php

use yii\db\Migration;

class m180114_053003_new_messages extends Migration
{
    public function safeUp()
    {
        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Show full description';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Показать полное описание';
        $mes->save();

        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Old price';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Старая цена';
        $mes->save();

        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Sale price';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Цена со скидкой';
        $mes->save();

        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Specify prices from the seller';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Уточняйте у продавца';
        $mes->save();

        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Wholesale only';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Товар продается только оптом';
        $mes->save();

        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Wholesales';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Оптовые цены';
        $mes->save();

        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'To Favorite';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'В Избранное';
        $mes->save();
        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Seller';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Продавец';
        $mes->save();

        /**---------------*/

        $mes = \common\models\Message::findOne(['id' => '128', 'language' => 'ru-RU']);
        $mes->translation = 'Купить сейчас';
        $mes->save();

        /**---------------*/

        $mes = \common\models\Message::findOne(['id' => '65', 'language' => 'ru-RU']);
        $mes->translation = 'посмотреть на карте';
        $mes->save();

        /**---------------*/

        $mes = \common\models\Message::findOne(['id' => '32', 'language' => 'ru-RU']);
        $mes->translation = 'Магазин принимает<br /> оплату при помощи:';
        $mes->save();

        /**---------------*/


    }

    public function safeDown()
    {
        echo "m180114_053003_new_messages cannot be reverted.\n";

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180114_053003_new_messages cannot be reverted.\n";

        return false;
    }
    */
}
