<?php

use yii\db\Migration;

class m181026_100420_add_range_option_groups extends Migration
{
    public function safeUp()
    {
        $this->addColumn('option_groups', 'range', $this->boolean()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('option_groups', 'range');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181026_100420_add_range_option_groups cannot be reverted.\n";

        return false;
    }
    */
}
