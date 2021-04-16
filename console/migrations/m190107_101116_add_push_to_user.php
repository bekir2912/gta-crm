<?php

use yii\db\Migration;

class m190107_101116_add_push_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'push', $this->boolean()->defaultValue(1));
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'push');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190107_101116_add_push_to_user cannot be reverted.\n";

        return false;
    }
    */
}
