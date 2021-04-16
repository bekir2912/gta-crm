<?php

use yii\db\Migration;

class m180303_100822_change_someMessages extends Migration
{
    public function safeUp()
    {
        $mes = \common\models\Message::find()->where(['language' => 'ru-RU', 'id' => 63])->one();
        $mes->translation = 'Служба поддержки';
        $mes->save();
        $mes = \common\models\Message::find()->where(['language' => 'ru-RU', 'id' => 7])->one();
        $mes->translation = '<span class="hidden-xs">Разработано в студии </span><a href="https://qwerty.uz/" class=\'qwerty\' target="_blank">QWERTY</a>';
        $mes->save();
        $mes = \common\models\Message::find()->where(['language' => 'ru-RU', 'id' => 184])->one();
        $mes->translation = 'Свидетельство';
        $mes->save();


        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Licence';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Лицензия на оптовую торговлю';
        $mes->save();

        /**---------------*/

        $this->addColumn('shops', 'licence', $this->string()->after('certificate'));
        $this->addColumn('unit_translations', 'full_name', $this->string()->after('name'));
    }

    public function safeDown()
    {
        $this->dropColumn('unit_translations', 'full_name');
        $this->dropColumn('shops', 'licence');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180303_100822_change_someMessages cannot be reverted.\n";

        return false;
    }
    */
}
