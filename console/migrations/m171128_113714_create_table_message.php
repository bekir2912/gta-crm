<?php

use yii\db\Migration;

class m171128_113714_create_table_message extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%message}}', [
            'id' => $this->integer(11)->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('primary_key', '{{%message}}', ['id','language']);

    }

    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
