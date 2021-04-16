<?php

use common\models\Product;
use common\models\Seller;
use common\models\Shop;
use yii\db\Migration;

class m180112_002912_refresh_sellers extends Migration
{
    public function safeUp()
    {
//        Seller::deleteAll();
//        Shop::deleteAll();
//        Product::deleteAll();
    }

    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180112_002912_refresh_sellers cannot be reverted.\n";

        return false;
    }
    */
}
