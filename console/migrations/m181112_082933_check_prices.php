<?php

use yii\db\Migration;

class m181112_082933_check_prices extends Migration
{
    public function safeUp()
    {
        $products = \common\models\Product::find()->all();
        foreach ($products as $product) {
            if($product->currency != 'uzs' && $product->currency != 'usd') {
                $product->currency = 'uzs';
            }
            if($product->currency == 'uzs') {
                $product->price_usd = round($product->price / 8249.97);
            } else if($product->currency == 'usd') {
                $product->price_usd = $product->price;
                $product->price = round($product->price_usd * 8249.97);
            }
            $product->save();
        }
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
        echo "m181112_082933_check_prices cannot be reverted.\n";

        return false;
    }
    */
}
