<?php

use yii\db\Migration;

class m171128_113715_create_table_shop_addresses extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%shop_addresses}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'shop_id' => $this->integer(11)->notNull(),
            'description' => $this->text(),
            'address' => $this->text(),
            'schedule' => $this->text(),
            'lat' => $this->string(255)->notNull(),
            'lng' => $this->string(255)->notNull(),
            'phone' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%shop_addresses}}');
    }
}
