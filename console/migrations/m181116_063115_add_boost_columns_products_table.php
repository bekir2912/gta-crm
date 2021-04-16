<?php

use yii\db\Migration;

class m181116_063115_add_boost_columns_products_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('products', 'colored_offer', $this->integer(11)->null()->defaultValue(null));
        $this->addColumn('products', 'special_offer', $this->integer(11)->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'colored_offer');
        $this->dropColumn('products', 'special_offer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181116_063115_add_boost_columns_products_table cannot be reverted.\n";

        return false;
    }
    */
}
