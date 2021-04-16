<?php

use yii\db\Migration;

class m180312_024412_empty_shops_schedule extends Migration
{
    public function safeUp()
    {
        \common\models\ShopAddresses::updateAll(['schedule' => '']);
    }

    public function safeDown()
    {
    }
}
