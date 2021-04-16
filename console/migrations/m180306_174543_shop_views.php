<?php

use common\models\Product;
use yii\db\Migration;

class m180306_174543_shop_views extends Migration
{
    public function safeUp()
    {
        $this->addColumn('shops', 'view', $this->integer()->defaultValue(0));
        $this->addColumn('shops', 'view_prods', $this->integer()->defaultValue(0));
        $this->addColumn('shops', 'view_phone', $this->integer()->defaultValue(0));
        Product::updateAll(['view' => 0]);
    }

    public function safeDown()
    {
        $this->dropColumn('shops', 'view');
        $this->dropColumn('shops', 'view_prods');
        $this->dropColumn('shops', 'view_phone');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180306_174543_shop_views cannot be reverted.\n";

        return false;
    }
    */
}
