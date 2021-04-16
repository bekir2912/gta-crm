<?php

use yii\db\Migration;

class m181119_125544_new_msgs extends Migration
{
    public function safeUp()
    {

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Switch on';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Вкл/выкл';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Phone placeholder';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = '+998XXAAABBCC';
        $mes->save();
    }

    public function safeDown()
    {
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Switch on']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Phone placeholder']);
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
        echo "m181119_125544_new_msgs cannot be reverted.\n";

        return false;
    }
    */
}
