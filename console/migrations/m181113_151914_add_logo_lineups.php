<?php

use yii\db\Migration;

class m181113_151914_add_logo_lineups extends Migration
{
    public function safeUp()
    {
        $this->addColumn('lineups', 'logo', $this->string()->null()->defaultValue('/uploads/site/default_cat.png'));
    }

    public function safeDown()
    {
        $this->dropColumn('lineups', 'logo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_151914_add_logo_lineups cannot be reverted.\n";

        return false;
    }
    */
}
