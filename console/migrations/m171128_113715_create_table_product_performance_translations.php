<?php

use yii\db\Migration;

class m171128_113715_create_table_product_performance_translations extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_performance_translations}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'product_performance_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%product_performance_translations}}');
    }
}
