<?php

use yii\db\Migration;

class m180312_101107_disable_en_lang extends Migration
{
    public function safeUp()
    {
        \common\models\Language::updateAll(['status' => 0], ['id' => 1]);
    }

    public function safeDown()
    {
    }
}
