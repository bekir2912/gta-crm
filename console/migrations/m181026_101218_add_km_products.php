<?php

use yii\db\Migration;

class m181026_101218_add_km_products extends Migration
{

    public function safeUp()
    {
        $this->addColumn('products', 'km', $this->bigInteger()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'km');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181026_101218_add_km_products cannot be reverted.\n";

        return false;
    }
    */
}
