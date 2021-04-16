<?php

use yii\db\Migration;

class m180116_025706_new_mes extends Migration
{
    public function safeUp()
    {

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'In ordering';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Нет в наличии, под заказ!';
        $mes->save();

        /**---------------*/
    }

    public function safeDown()
    {
//        echo "m180116_025706_new_mes cannot be reverted.\n";
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
        echo "m180116_025706_new_mes cannot be reverted.\n";

        return false;
    }
    */
}
