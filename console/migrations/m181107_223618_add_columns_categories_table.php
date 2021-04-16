<?php

use yii\db\Migration;

class m181107_223618_add_columns_categories_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('categories', 'spec', $this->boolean()->defaultValue(0));
        $this->addColumn('categories', 'view', $this->bigInteger()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('categories', 'spec');
        $this->dropColumn('categories', 'view');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181107_223618_add_columns_categories_table cannot be reverted.\n";

        return false;
    }
    */
}
