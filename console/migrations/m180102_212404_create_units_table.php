<?php

use yii\db\Migration;

/**
 * Handles the creation of table `units`.
 */
class m180102_212404_create_units_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('units', [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);

        $this->createTable('unit_translations', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'unit_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('unit_translations');
        $this->dropTable('units');
    }
}
