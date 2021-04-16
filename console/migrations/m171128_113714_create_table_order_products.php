<?php

use yii\db\Migration;

class m171128_113714_create_table_order_products extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_products}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'order_id' => $this->integer(11)->notNull(),
            'product_id' => $this->integer(11)->notNull(),
            'options' => $this->text(),
            'price' => $this->integer(11)->notNull(),
            'sale' => $this->double()->notNull(),
            'amount' => $this->integer(11)->notNull(),
            'sum' => $this->integer(11)->notNull(),
            'comment_status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'comment_rate' => $this->integer(11)->notNull()->defaultValue('0'),
            'comment' => $this->text(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%order_products}}');
    }
}
