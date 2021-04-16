<?php

use yii\db\Migration;

class m181025_181956_add_type_to_option_groups extends Migration
{
    public function safeUp()
    {
        $this->addColumn('option_groups', 'type', $this->boolean()->defaultValue(0));
        $this->addColumn('option_groups', 'main', $this->boolean()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('option_groups', 'main');
        $this->dropColumn('option_groups', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181025_181956_add_type_to_option_groups cannot be reverted.\n";

        return false;
    }
    */
}
