<?php

use yii\db\Migration;

class m190118_070703_change_chat_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn("chat", 'message', $this->text()->null());
    }

    public function safeDown()
    {
        $this->alterColumn("chat", 'message', $this->text());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190118_070703_change_chat_table cannot be reverted.\n";

        return false;
    }
    */
}
