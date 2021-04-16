<?php

use yii\db\Migration;

class m171128_113714_create_table_chat extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%chat}}', [
            'id' => $this->integer(10)->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'user_id' => $this->integer(10)->unsigned()->notNull(),
            'shop_id' => $this->integer(10)->unsigned()->notNull(),
            'direction' => $this->smallInteger(1)->unsigned()->notNull(),
            'message' => $this->text()->notNull(),
            'is_read' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue('0'),
            'created_at' => $this->integer(32),
            'updated_at' => $this->integer(32),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%chat}}');
    }
}
