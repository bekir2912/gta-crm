<?php

use yii\db\Migration;

class m190121_170522_add_file_to_fourm extends Migration
{
    public function safeUp()
    {
        $this->addColumn('questions', 'file', $this->string()->null());
        $this->addColumn('answers', 'file', $this->string()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('questions', 'file');
        $this->dropColumn('answers', 'file');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190121_170522_add_file_to_fourm cannot be reverted.\n";

        return false;
    }
    */
}
