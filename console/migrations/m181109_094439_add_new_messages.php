<?php

use yii\db\Migration;

class m181109_094439_add_new_messages extends Migration
{
    public function safeUp()
    {

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Notice';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Указанная стоимость работ является примерной и может отличаться от действительной. Точную стоимость услуг узнавайте у представителей автосервиса';
        $mes->save();
    }

    public function safeDown()
    {
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Notice']);
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
        echo "m181109_094439_add_new_messages cannot be reverted.\n";

        return false;
    }
    */
}
