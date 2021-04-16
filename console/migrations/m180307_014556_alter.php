<?php

use yii\db\Migration;

class m180307_014556_alter extends Migration
{
    public function safeUp()
    {
        $this->addColumn('products', 'add_cats', $this->text());
        $this->addColumn('products', 'add_cats_titles', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'add_cats');
        $this->dropColumn('products', 'add_cats_titles');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180307_014556_alter cannot be reverted.\n";

        return false;
    }
    */
}
