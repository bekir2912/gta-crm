<?php

use yii\db\Migration;

/**
 * Handles the creation of table `radars`.
 */
class m181029_192632_create_radars_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('radars', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(11)->notNull(),
            'type' => $this->boolean()->null()->defaultValue(0),
            'lat' => $this->string(255),
            'lng' => $this->string(255),
            'address' => $this->text(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('radars');
    }
}
