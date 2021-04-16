<?php

use yii\db\Migration;

class m181118_152154_refactor_user_seller_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('user', 'email');
        $this->dropColumn('sellers', 'email');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('sellers', 'phone');
        $this->addColumn('user', 'phone', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('sellers', 'phone', $this->string(500)->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->addColumn('user', 'email', $this->string());
        $this->addColumn('sellers', 'email', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181118_152154_refactor_user_seller_table cannot be reverted.\n";

        return false;
    }
    */
}
