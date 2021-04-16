<?php

use yii\db\Migration;

class m181028_185208_alter_brand_id_products extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('products', 'brand_id', $this->integer()->null());
    }

    public function safeDown()
    {
        $this->alterColumn('products', 'price', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181028_185208_alter_brand_id_products cannot be reverted.\n";

        return false;
    }
    */
}
