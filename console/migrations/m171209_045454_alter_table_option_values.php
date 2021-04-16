<?php

use yii\db\Migration;

class m171209_045454_alter_table_option_values extends Migration
{
    public function safeUp()
    {
        $this->addColumn('option_values', 'image', $this->string(255)->defaultValue(''));
    }

    public function safeDown()
    {
        $this->dropColumn('option_values', 'image');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171209_045454_alter_table_option_values cannot be reverted.\n";

        return false;
    }
    */
}
