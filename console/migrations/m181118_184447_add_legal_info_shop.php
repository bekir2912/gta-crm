<?php

use yii\db\Migration;

class m181118_184447_add_legal_info_shop extends Migration
{
    public function safeUp()
    {
        $this->addColumn('shops', 'legal_name', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'trademark', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'legal_address', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'physical_address', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'legal_phone', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'rs', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'bank', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'bank_city', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'mfo', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'inn', $this->string(500)->null()->defaultValue(null));
        $this->addColumn('shops', 'okonh', $this->string(500)->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('shops', 'legal_name');
        $this->dropColumn('shops', 'trademark');
        $this->dropColumn('shops', 'legal_address');
        $this->dropColumn('shops', 'physical_address');
        $this->dropColumn('shops', 'legal_phone');
        $this->dropColumn('shops', 'rs');
        $this->dropColumn('shops', 'bank');
        $this->dropColumn('shops', 'bank_city');
        $this->dropColumn('shops', 'mfo');
        $this->dropColumn('shops', 'inn');
        $this->dropColumn('shops', 'okonh');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181118_184447_add_legal_info_shop cannot be reverted.\n";

        return false;
    }
    */
}
