<?php

use yii\db\Migration;

class m171128_113714_create_table_admins extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admins}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'username' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'status' => $this->smallInteger(6)->notNull()->defaultValue('10'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('username', '{{%admins}}', 'username', true);
        $this->createIndex('password_reset_token', '{{%admins}}', 'password_reset_token', true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%admins}}');
    }
}
