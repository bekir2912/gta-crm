<?php

use yii\db\Migration;

class m171128_113714_create_table_orders extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'shop_id' => $this->integer(11)->notNull(),
            'service' => $this->double(),
            'delivery_id' => $this->integer(11),
            'user_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255),
            'phone' => $this->string(255),
            'email' => $this->string(255),
            'address' => $this->text(),
            'pay_method' => $this->integer(11)->notNull()->defaultValue('0'),
            'sum' => $this->integer(11)->notNull(),
            'comment_status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'comment_rate' => $this->integer(11)->notNull()->defaultValue('0'),
            'comment' => $this->text(),
            'pay_status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'pay_amount' => $this->integer(11)->notNull()->defaultValue('0'),
            'transaction' => $this->text(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
