<?php

use yii\db\Migration;

class m180312_193107_alter_prods_prices extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('products', 'price', $this->double()->defaultValue(0));
        $this->addColumn('products', 'from', $this->integer()->defaultValue(0)->after('sale_id'));
        $this->addColumn('sales', 'type', $this->integer()->defaultValue(0)->after('name'));
    }

    public function safeDown()
    {
        $this->alterColumn('products', 'price', $this->integer(11)->defaultValue(0));
        $this->dropColumn('products', 'from');
        $this->dropColumn('sales', 'type');
    }
}
