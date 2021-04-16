<?php

use yii\db\Migration;

class m171128_113715_create_table_static_pages extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%static_pages}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'category_id' => $this->integer(11)->notNull(),
            'url' => $this->string(255)->notNull(),
            'external' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'order' => $this->integer(11)->notNull()->defaultValue('0'),
            'on_top' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%static_pages}}');
    }
}
