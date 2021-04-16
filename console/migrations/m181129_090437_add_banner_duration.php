<?php

use yii\db\Migration;

class m181129_090437_add_banner_duration extends Migration
{
    public function safeUp()
    {

        $this->addColumn('banners', 'expires_in', $this->integer()->defaultValue(1575061200));
    }

    public function safeDown()
    {
        $this->dropColumn('banners', 'expires_in');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181129_090437_add_banner_duration cannot be reverted.\n";

        return false;
    }
    */
}
