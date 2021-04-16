<?php

use yii\db\Migration;

class m181115_074617_new_messages extends Migration
{
    public function safeUp()
    {
        $lang = \common\models\Language::findOne(3);
        $lang->name = "Узб";
        $lang->save();
    }

    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_074617_new_messages cannot be reverted.\n";

        return false;
    }
    */
}
