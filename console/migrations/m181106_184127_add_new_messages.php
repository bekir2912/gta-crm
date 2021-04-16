<?php

use yii\db\Migration;

class m181106_184127_add_new_messages extends Migration
{
    public function safeUp()
    {

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Partners panel';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Вход для партнеров';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Currency';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Валюта';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'usd';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'usd';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'oz';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'O\'zbek';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'My ID Ucard';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Мой ID Ucard';
        $mes->save();
    }

    public function safeDown()
    {
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Partners panel']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Currency']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'usd']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'oz']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'My ID Ucard']);
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
        echo "m181106_184127_add_new_messages cannot be reverted.\n";

        return false;
    }
    */
}
