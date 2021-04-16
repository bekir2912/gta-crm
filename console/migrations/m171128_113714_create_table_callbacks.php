<?php

use yii\db\Migration;

class m171128_113714_create_table_callbacks extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%callbacks}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'shop_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255),
            'phone' => $this->string(255),
            'status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%callbacks}}');
    }
}
