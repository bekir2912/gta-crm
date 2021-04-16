<?php

use yii\db\Migration;

class m190109_215956_add_is_read_on_questions_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('answers', 'is_read', $this->boolean()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('answers', 'is_read');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190109_215956_add_is_read_on_questions_table cannot be reverted.\n";

        return false;
    }
    */
}
