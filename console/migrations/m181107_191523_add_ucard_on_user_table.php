<?php

use yii\db\Migration;

class m181107_191523_add_ucard_on_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'ucard', $this->integer()->null()->defaultValue(null));
        $this->addColumn('sellers', 'ucard', $this->integer()->null()->defaultValue(null));
        $this->addColumn('sellers', 'balance', $this->bigInteger()->null()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'ucard');
        $this->dropColumn('sellers', 'ucard');
        $this->dropColumn('sellers', 'balance');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181107_191523_add_ucard_on_user_table cannot be reverted.\n";

        return false;
    }
    */
}
