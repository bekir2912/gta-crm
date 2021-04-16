<?php

use yii\db\Migration;

class m181113_213736_add_new_language extends Migration
{
    public function safeUp()
    {
        $language = new \common\models\Language();
        $language->url = 'oz';
        $language->local = 'oz-OZ';
        $language->name = 'Uzb';
        $language->default = 0;
        $language->order = 4;
        $language->status = 1;
        $language->created_at = time();
        $language->updated_at = time();
        $language->save();

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'oz';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'O\'zbekcha';
        $mes->save();
    }

    public function safeDown()
    {
        $source_mes = \common\models\SourceMessage::findOne(['message' => 'oz']);
        if($source_mes) {
            $mes = \common\models\Message::findOne(['id' => $source_mes->id]);
            $mes->delete();
            $source_mes->delete();
        }
        \common\models\Language::deleteAll(['url' => 'oz']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_213736_add_new_language cannot be reverted.\n";

        return false;
    }
    */
}
