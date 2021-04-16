<?php

use yii\db\Migration;

class m171128_114121_foreign_keys_init extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        $this->addForeignKey('fk-auth-user_id-user-id', '{{%auth}}', 'user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk-banner_translations-banner_id2', '{{%banner_translations}}', 'banner_id', '{{%banners}}', 'id');
        $this->addForeignKey('fk-banner_translations-local2', '{{%banner_translations}}', 'local', '{{%languages}}', 'local');

        $this->addForeignKey('fk-brands-category_id1', '{{%brands}}', 'category_id', '{{%categories}}', 'id');

        $this->addForeignKey('fk-callbacks-shop_id', '{{%callbacks}}', 'shop_id', '{{%shops}}', 'id');

        $this->addForeignKey('fk-categories-parent_id', '{{%categories}}', 'parent_id', '{{%categories}}', 'id');

        $this->addForeignKey('fk-category_translations-category_id', '{{%category_translations}}', 'category_id', '{{%categories}}', 'id');
        $this->addForeignKey('fk-category_translations-local_3', '{{%category_translations}}', 'local', '{{%languages}}', 'local');

        $this->addForeignKey('fk_message_source_message', '{{%message}}', 'id', '{{%source_message}}', 'id');

        $this->addForeignKey('fk-news_translations-local1', '{{%news_translations}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-news_translations-news_id1', '{{%news_translations}}', 'news_id', '{{%news}}', 'id');

        $this->addForeignKey('fk-option_groups-category_id', '{{%option_groups}}', 'category_id', '{{%categories}}', 'id');

        $this->addForeignKey('fk-option_group_translations-group_id', '{{%option_groups_translations}}', 'group_id', '{{%option_groups}}', 'id');
        $this->addForeignKey('fk-option_group_translations-local', '{{%option_groups_translations}}', 'local', '{{%languages}}', 'local');

        $this->addForeignKey('fk-option_values-group_id', '{{%option_values}}', 'group_id', '{{%option_groups}}', 'id');

        $this->addForeignKey('fk-option_values_translations-local', '{{%option_values_translations}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-option_values_translations-option_id', '{{%option_values_translations}}', 'option_id', '{{%option_values}}', 'id');

        $this->addForeignKey('fk-order_products-order_id', '{{%order_products}}', 'order_id', '{{%orders}}', 'id');
        $this->addForeignKey('fk-order_products-product_id', '{{%order_products}}', 'product_id', '{{%products}}', 'id');

        $this->addForeignKey('fk-orders-delivery_id', '{{%orders}}', 'delivery_id', '{{%shop_deliveries}}', 'id');
        $this->addForeignKey('fk-orders-shop_id', '{{%orders}}', 'shop_id', '{{%shops}}', 'id');
        $this->addForeignKey('fk-orders-user_id', '{{%orders}}', 'user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk-product_images-product_id1', '{{%product_images}}', 'product_id', '{{%products}}', 'id');

        $this->addForeignKey('fk-product_options-option_id', '{{%product_options}}', 'option_id', '{{%option_values}}', 'id');
        $this->addForeignKey('fk-product_options-product_id', '{{%product_options}}', 'product_id', '{{%products}}', 'id');

        $this->addForeignKey('fk-product_performance_translations-local_1', '{{%product_performance_translations}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-product_performance_translations-product_performance_id', '{{%product_performance_translations}}', 'product_performance_id', '{{%product_performances}}', 'id');

        $this->addForeignKey('fk-product_performances-product_id', '{{%product_performances}}', 'product_id', '{{%products}}', 'id');

        $this->addForeignKey('fk-product_translations-local_1', '{{%product_translations}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-product_translations-product_id1', '{{%product_translations}}', 'product_id', '{{%products}}', 'id');

        $this->addForeignKey('fk-products-category_id1', '{{%products}}', 'category_id', '{{%categories}}', 'id');
        $this->addForeignKey('fk-products-sale_id32', '{{%products}}', 'sale_id', '{{%sales}}', 'id');
        $this->addForeignKey('fk-products-shop_id1', '{{%products}}', 'shop_id', '{{%shops}}', 'id');

        $this->addForeignKey('fk-sales-shop_id22', '{{%sales}}', 'shop_id', '{{%shops}}', 'id');

        $this->addForeignKey('fk-shop_addresses-local_1', '{{%shop_addresses}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-shop_addresses-shop_id', '{{%shop_addresses}}', 'shop_id', '{{%shops}}', 'id');

        $this->addForeignKey('fk-shop_deliveries-shop_id1', '{{%shop_deliveries}}', 'shop_id', '{{%shops}}', 'id');

        $this->addForeignKey('fk-shop_delivery_translation-local_1', '{{%shop_delivery_translations}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-shop_delivery_translation-shop_delivery_id', '{{%shop_delivery_translations}}', 'shop_delivery_id', '{{%shop_deliveries}}', 'id');

        $this->addForeignKey('fk-shops-seller_id', '{{%shops}}', 'seller_id', '{{%sellers}}', 'id');

        $this->addForeignKey('fk-static_page_category_translations-category_id', '{{%static_page_category_translations}}', 'category_id', '{{%static_page_categories}}', 'id');
        $this->addForeignKey('fk-static_page_category_translations-local', '{{%static_page_category_translations}}', 'local', '{{%languages}}', 'local');

        $this->addForeignKey('fk-category_translations-local', '{{%static_page_translations}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-static_page_translations-local', '{{%static_page_translations}}', 'local', '{{%languages}}', 'local');
        $this->addForeignKey('fk-static_page_translations-static_page_id', '{{%static_page_translations}}', 'static_page_id', '{{%static_pages}}', 'id');

        $this->addForeignKey('fk-static_pages-category_id', '{{%static_pages}}', 'category_id', '{{%static_page_categories}}', 'id');

        $this->addForeignKey('fk-user_addresses-user_id1', '{{%user_addresses}}', 'user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk-user_carts-product_id1', '{{%user_cart}}', 'product_id', '{{%products}}', 'id');
        $this->addForeignKey('fk-user_carts-user_id1', '{{%user_cart}}', 'user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk-user_favorite-product_id', '{{%user_favorite}}', 'product_id', '{{%products}}', 'id');
        $this->addForeignKey('fk-user_favorite-user_id', '{{%user_favorite}}', 'user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk-user_recents-product_id', '{{%user_recents}}', 'product_id', '{{%products}}', 'id');
        $this->addForeignKey('fk-user_recents-user_id', '{{%user_recents}}', 'user_id', '{{%user}}', 'id');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171128_114121_foreign_keys_init cannot be reverted.\n";

        return false;
    }
    */
}
