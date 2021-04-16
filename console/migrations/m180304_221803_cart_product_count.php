<?php

use yii\db\Migration;

class m180304_221803_cart_product_count extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user_cart', 'count', $this->integer());
        $this->dropColumn('unit_translations', 'full_name');

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Count';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Кол-во';
        $mes->save();

        /**---------------*/
    }

    public function safeDown()
    {
        $this->dropColumn('user_cart', 'count');
        $this->addColumn('unit_translations', 'full_name', $this->string()->after('name'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180304_221803_cart_product_count cannot be reverted.\n";

        return false;
    }
    */
}
