<?php

use yii\db\Migration;

class m171128_113714_create_table_payment_systems extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payment_systems}}', [
            'id' => $this->integer(11)->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'logo' => $this->string(500)->notNull(),
            'name' => $this->string(500)->notNull(),
            'status' => $this->smallInteger(1)->unsigned()->notNull(),
            'created_at' => $this->integer(32)->unsigned()->notNull(),
            'updated_at' => $this->integer(32)->unsigned()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%payment_systems}}');
    }
}
