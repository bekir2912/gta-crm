<?php

use yii\db\Migration;

class m190119_063915_add_is_moderated_column extends Migration
{
    public function safeUp()
    {
        $this->addColumn('products', 'is_moderated', $this->boolean()->defaultValue(0));
        $this->addColumn('shop_reviews', 'is_moderated', $this->boolean()->defaultValue(0));
        $this->addColumn('questions', 'is_moderated', $this->boolean()->defaultValue(0));
        $this->addColumn('answers', 'is_moderated', $this->boolean()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'is_moderated');
        $this->dropColumn('shop_reviews', 'is_moderated');
        $this->dropColumn('questions', 'is_moderated');
        $this->dropColumn('answers', 'is_moderated');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190119_063915_add_is_moderated_column cannot be reverted.\n";

        return false;
    }
    */
}
