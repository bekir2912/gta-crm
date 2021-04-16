<?php

use yii\db\Migration;

class m180401_235938_another_new_messages extends Migration
{
    public function safeUp()
    {

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'NEW STICKER';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'НОВИНКА';
        $mes->save();

        /**---------------*/
        $mes = \common\models\Message::findOne(['id' => 10, 'language' => 'ru-RU']);
        $mes->translation = 'НОВИНКИ НА САЙТЕ';
        $mes->save();

        /**---------------*/
        $mes = \common\models\Message::findOne(['id' => 103, 'language' => 'ru-RU']);
        $mes->translation = 'Магазины на сайте';
        $mes->save();

        /**---------------*/
        $mes = \common\models\Message::findOne(['id' => 106, 'language' => 'ru-RU']);
        $mes->translation = 'ХИТЫ ПРОДАЖ';
        $mes->save();

        /**---------------*/
        $mes = \common\models\Message::findOne(['id' => 21, 'language' => 'ru-RU']);
        $mes->translation = 'Бренды товаров';
        $mes->save();

        /**---------------*/
    }

    public function safeDown()
    {
//        echo "m180401_235938_another_new_messages cannot be reverted.\n";
//
//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180401_235938_another_new_messages cannot be reverted.\n";

        return false;
    }
    */
}
