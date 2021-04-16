<?php

use yii\db\Migration;

class m171128_113715_create_table_shop_delivery_translations extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%shop_delivery_translations}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'shop_delivery_id' => $this->integer(11)->notNull(),
            'method' => $this->string(255)->notNull(),
            'description' => $this->string(500)->notNull(),
            'schedule' => $this->string(255)->notNull(),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%shop_delivery_translations}}');
    }
}
