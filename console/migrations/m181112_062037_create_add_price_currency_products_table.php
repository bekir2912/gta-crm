<?php

use yii\db\Migration;

/**
 * Handles the creation of table `add_price_currency_products`.
 */
class m181112_062037_create_add_price_currency_products_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('products', 'currency', $this->string()->null()->defaultValue('uzs'));
        $this->addColumn('products', 'price_usd', $this->double()->null()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('products', 'currency');
        $this->dropColumn('products', 'price_usd');
    }
}
