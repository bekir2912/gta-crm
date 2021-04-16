<?php

use yii\db\Migration;

class m171128_113715_create_table_shop_deliveries extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%shop_deliveries}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'shop_id' => $this->integer(11)->notNull(),
            'price' => $this->integer(11)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%shop_deliveries}}');
    }
}
