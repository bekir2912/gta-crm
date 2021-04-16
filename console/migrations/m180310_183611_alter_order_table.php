<?php

use yii\db\Migration;

class m180310_183611_alter_order_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('orders', 'which_pay', $this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('orders', 'which_pay');
    }
}
