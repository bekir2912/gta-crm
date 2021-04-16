<?php

use yii\db\Migration;

class m181113_061350_add_column_products_table extends Migration
{
    public function safeUp()
    {

        $this->addColumn('products', 'wholesale_usd', $this->text()->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'wholesale_usd');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_061350_add_column_products_table cannot be reverted.\n";

        return false;
    }
    */
}
