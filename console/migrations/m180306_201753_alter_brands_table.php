<?php

use yii\db\Migration;

class m180306_201753_alter_brands_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('brands', 'logo', $this->string(255)->after('name')->defaultValue(''));
        \common\models\Brand::updateAll(['logo' =>  '/uploads/site/default_cat.png']);

//        $source_mes = new \common\models\SourceMessage();
//        $source_mes->category = 'frontend';
//        $source_mes->message = 'Empty';
//        $source_mes->save();
//
//        $mes = new \common\models\Message();
//        $mes->id = $source_mes->id;
//        $mes->language = 'ru-RU';
//        $mes->translation = 'Нет брендов';
//        $mes->save();

        /**---------------*/

        $source_mes = new \common\models\SourceMessage();
        $source_mes->category = 'frontend';
        $source_mes->message = 'Show all';
        $source_mes->save();

        $mes = new \common\models\Message();
        $mes->id = $source_mes->id;
        $mes->language = 'ru-RU';
        $mes->translation = 'Смотреть все';
        $mes->save();

    }

    public function safeDown()
    {
        $this->dropColumn('brands', 'logo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180306_201753_alter_brands_table cannot be reverted.\n";

        return false;
    }
    */
}
