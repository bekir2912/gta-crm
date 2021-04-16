<?php

use yii\db\Migration;

class m180312_210853_alter_other_prices extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('product_options', 'price', $this->double()->defaultValue(0));
        $this->alterColumn('orders', 'sum', $this->double()->defaultValue(0));
        $this->alterColumn('orders', 'pay_amount', $this->double()->defaultValue(0));
        $this->alterColumn('order_products', 'price', $this->double()->defaultValue(0));
        $this->alterColumn('order_products', 'sum', $this->double()->defaultValue(0));
        $this->addColumn('order_products', 'sale_type', $this->double()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->alterColumn('product_options', 'price', $this->integer(11)->defaultValue(0));
        $this->alterColumn('orders', 'sum', $this->integer(11)->defaultValue(0));
        $this->alterColumn('orders', 'pay_amount', $this->integer(11)->defaultValue(0));
        $this->alterColumn('order_products', 'price', $this->integer(11)->defaultValue(0));
        $this->alterColumn('order_products', 'sum', $this->integer(11)->defaultValue(0));
        $this->dropColumn('order_products', 'sale_type');
    }
}
