<?php

use yii\db\Migration;

class m181031_105223_add_category_icon extends Migration
{
    public function safeUp()
    {
        \common\models\Category::updateAll(['icon' => '/uploads/site/test_icon.png']);
    }

    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_105223_add_category_icon cannot be reverted.\n";

        return false;
    }
    */
}
