<?php

use yii\db\Migration;

class m181030_084421_alter_cities_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cities', 'address', $this->text()->null());
        $this->addColumn('cities', 'lat', $this->string(255)->null());
        $this->addColumn('cities', 'lng', $this->string(255)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('cities', 'address');
        $this->dropColumn('cities', 'lat');
        $this->dropColumn('cities', 'lng');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181030_084421_alter_cities_table cannot be reverted.\n";

        return false;
    }
    */
}
