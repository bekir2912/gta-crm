<?php

use yii\db\Migration;

class m171128_113715_create_table_shops extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%shops}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'seller_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'image' => $this->string(255)->notNull(),
            'logo' => $this->string(255)->notNull(),
            'certificate' => $this->string(255),
            'url' => $this->string(255)->notNull(),
            'order' => $this->integer(11)->notNull()->defaultValue('0'),
            'online_pay' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'payments' => $this->text(),
            'top' => $this->integer(11)->notNull()->defaultValue('0'),
            'top_order' => $this->integer(11)->notNull()->defaultValue('0'),
            'on_main' => $this->smallInteger(1)->defaultValue('0'),
            'status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'service' => $this->double()->defaultValue('0'),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%shops}}');
    }
}
