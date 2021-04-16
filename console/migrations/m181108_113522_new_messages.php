<?php

use yii\db\Migration;

class m181108_113522_new_messages extends Migration
{
    public function safeUp()
    {

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Forum all themes';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Все темы форума';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Add Forum Theme';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Добавить тему для форума';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Forum Theme';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Тема форума';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Add answer';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Добавить ответ';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Answer text';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Напишите текст своего ответа';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Auth to add answer';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Авторизуйтесь что бы оставить ответ';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'With photo';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Только с фото';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Search by theme';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Поиски по форуму';
        $mes->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Confirm deleting';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Уверены что хотите удалить?';
        $mes->save();
    }

    public function safeDown()
    {
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Forum all themes']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Add Forum Theme']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Forum Theme']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Add answer']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Answer text']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Auth to add answer']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'With photo']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Search by theme']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'Confirm deleting']);
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
        echo "m181108_113522_new_messages cannot be reverted.\n";

        return false;
    }
    */
}
