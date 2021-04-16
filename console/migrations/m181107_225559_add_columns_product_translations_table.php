<?php

use yii\db\Migration;

class m181107_225559_add_columns_product_translations_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('product_translations', 'delivery', $this->text()->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('product_translations', 'delivery');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181107_225559_add_columns_product_translations_table cannot be reverted.\n";

        return false;
    }
    */
}
