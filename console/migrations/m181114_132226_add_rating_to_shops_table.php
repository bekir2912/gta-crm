<?php

use yii\db\Migration;

class m181114_132226_add_rating_to_shops_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('shops', 'rating', $this->double()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('shops', 'rating');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_132226_add_rating_to_shops_table cannot be reverted.\n";

        return false;
    }
    */
}
