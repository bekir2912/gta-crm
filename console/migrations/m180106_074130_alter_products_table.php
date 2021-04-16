<?php

use yii\db\Migration;

class m180106_074130_alter_products_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('products', 'unit_id', $this->integer(11)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'unit_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180106_074130_alter_products_table cannot be reverted.\n";

        return false;
    }
    */
}
