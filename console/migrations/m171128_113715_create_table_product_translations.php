<?php

use yii\db\Migration;

class m171128_113715_create_table_product_translations extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_translations}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'product_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'warranty' => $this->text(),
            'meta_title' => $this->string(255),
            'meta_description' => $this->text(),
            'meta_keys' => $this->text(),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_translations}}');
    }
}
