<?php

use yii\db\Migration;

class m171128_113715_create_table_source_message extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%source_message}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'category' => $this->string(255),
            'message' => $this->text(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%source_message}}');
    }
}
