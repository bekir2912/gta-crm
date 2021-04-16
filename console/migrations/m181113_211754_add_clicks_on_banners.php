<?php

use yii\db\Migration;

class m181113_211754_add_clicks_on_banners extends Migration
{
    public function safeUp()
    {
        $this->addColumn('banners', 'clicks', $this->bigInteger()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('banners', 'clicks');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_211754_add_clicks_on_banners cannot be reverted.\n";

        return false;
    }
    */
}
