<?php

use yii\db\Migration;

class m171128_113714_create_table_news_translations extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%news_translations}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'news_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'short' => $this->text(),
            'text' => $this->text(),
            'image' => $this->string(255)->notNull(),
            'meta_title' => $this->string(255)->notNull(),
            'meta_description' => $this->text(),
            'meta_keys' => $this->text(),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%news_translations}}');
    }
}
