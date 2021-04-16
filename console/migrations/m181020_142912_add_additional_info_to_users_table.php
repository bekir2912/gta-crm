<?php

use yii\db\Migration;

class m181020_142912_add_additional_info_to_users_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'city_id', $this->integer(11)->null()->defaultValue(null));
        $this->addColumn('user', 'birthday', $this->string(255)->null()->defaultValue(null));
        $this->addColumn('user', 'avatar', $this->string(255)->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'city_id');
        $this->dropColumn('user', 'birthday');
        $this->dropColumn('user', 'avatar');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181020_142912_add_additional_info_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
