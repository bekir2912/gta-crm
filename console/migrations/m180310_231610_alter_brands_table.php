<?php

use yii\db\Migration;

class m180310_231610_alter_brands_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('brands', 'on_main', $this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('brands', 'on_main');
    }
}
