<?php

use yii\db\Migration;

class m190114_075938_add_file_attach_to_chats extends Migration
{

    public function safeUp()
    {
        $this->addColumn('chat', 'hasFile', $this->boolean()->defaultValue(0));
        $this->addColumn('chat', 'fileType', $this->string()->null());
        $this->addColumn('chat', 'mime', $this->string()->null());
        $this->addColumn('chat', 'file', $this->string()->null());
        $this->addColumn('chat', 'geo', $this->string()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('chat', 'hasFile');
        $this->dropColumn('chat', 'fileType');
        $this->dropColumn('chat', 'mime');
        $this->dropColumn('chat', 'file');
        $this->dropColumn('chat', 'geo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190114_075938_add_file_attach_to_chats cannot be reverted.\n";

        return false;
    }
    */
}
