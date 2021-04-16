<?php

use yii\db\Migration;

class m181117_112015_add_type_to_banner extends Migration
{
    public function safeUp()
    {
        $this->addColumn('banners', 'type', $this->boolean()->null()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('banners', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181117_112015_add_type_to_banner cannot be reverted.\n";

        return false;
    }
    */
}
