<?php

use yii\db\Migration;

class m180112_000350_alter_products_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('products', 'in_order', $this->smallInteger(1)->notNull()->defaultValue('0'));
        $this->addColumn('products', 'price_type', $this->smallInteger(1)->notNull()->defaultValue('0'));
        $this->addColumn('products', 'wholesale', $this->text()->null());
        $this->addColumn('products', 'wholesale_unit_id', $this->integer(11)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'wholesale_unit_id');
        $this->dropColumn('products', 'wholesale');
        $this->dropColumn('products', 'price_type');
        $this->dropColumn('products', 'in_order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180112_000350_alter_products_table cannot be reverted.\n";

        return false;
    }
    */
}
