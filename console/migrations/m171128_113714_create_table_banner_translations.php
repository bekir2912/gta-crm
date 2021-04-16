<?php

use yii\db\Migration;

class m171128_113714_create_table_banner_translations extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%banner_translations}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'banner_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'image' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'url' => $this->string(500),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%banner_translations}}');
    }
}
