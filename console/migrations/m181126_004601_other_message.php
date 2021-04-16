<?php

use yii\db\Migration;

class m181126_004601_other_message extends Migration
{
    public function safeUp()
    {
        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Other';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Другое';
        $mes->save();

        $this->addColumn('products', 'custom_options', $this->text()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('products', 'custom_options');

        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Other']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181126_004601_other_message cannot be reverted.\n";

        return false;
    }
    */
}
