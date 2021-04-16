<?php

use yii\db\Migration;

class m180311_192451_soft_delete extends Migration
{
    public function safeUp()
    {
        $this->addColumn('shops', 'deleted_at', $this->integer(11)->defaultValue(0));
        $this->addColumn('sellers', 'deleted_at', $this->integer(11)->defaultValue(0));
        $this->addColumn('products', 'deleted_at', $this->integer(11)->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('shops', 'deleted_at');
        $this->dropColumn('sellers', 'deleted_at');
        $this->dropColumn('products', 'deleted_at');
    }
}
