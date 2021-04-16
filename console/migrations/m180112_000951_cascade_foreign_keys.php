<?php

use yii\db\Migration;

class m180112_000951_cascade_foreign_keys extends Migration
{
    public function safeUp()
    {
//        $this->addForeignKey('fk-auth-user_id-user-id13',
//            '{{%auth}}',
//            'user_id',
//            '{{%user}}',
//            'id',
//            'CASCADE'
//        );
//
//        $this->addForeignKey('fk-banner_translations-banner_id213',
//            '{{%banner_translations}}',
//            'banner_id',
//            '{{%banners}}',
//            'id',
//            'CASCADE');
//        $this->addForeignKey('fk-banner_translations-local213',
//            '{{%banner_translations}}',
//            'local',
//            '{{%languages}}',
//            'local',
//            'CASCADE');
//
//        $this->addForeignKey('fk-brands-category_id113',
//            '{{%brands}}',
//            'category_id',
//            '{{%categories}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-callbacks-shop_id13',
//            '{{%callbacks}}',
//            'shop_id',
//            '{{%shops}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-categories-parent_id13',
//            '{{%categories}}',
//            'parent_id',
//            '{{%categories}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-category_translations-category_id13',
//            '{{%category_translations}}',
//            'category_id',
//            '{{%categories}}',
//            'id',
//            'CASCADE');
//        $this->addForeignKey('fk-category_translations-local_313',
//            '{{%category_translations}}',
//            'local',
//            '{{%languages}}',
//            'local',
//            'CASCADE');
//
//        $this->addForeignKey('fk_message_source_message13',
//            '{{%message}}',
//            'id',
//            '{{%source_message}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-news_translations-local113',
//            '{{%news_translations}}',
//            'local',
//            '{{%languages}}',
//            'local',
//            'CASCADE');
//        $this->addForeignKey('fk-news_translations-news_id113',
//            '{{%news_translations}}',
//            'news_id',
//            '{{%news}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-option_groups-category_id13',
//            '{{%option_groups}}',
//            'category_id',
//            '{{%categories}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-option_group_translations-group_id13',
//            '{{%option_groups_translations}}',
//            'group_id',
//            '{{%option_groups}}',
//            'id',
//            'CASCADE');
//        $this->addForeignKey('fk-option_group_translations-local13',
//            '{{%option_groups_translations}}',
//            'local', '{{%languages}}',
//            'local',
//            'CASCADE');
//
//        $this->addForeignKey('fk-option_values-group_id13',
//            '{{%option_values}}',
//            'group_id',
//            '{{%option_groups}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-option_values_translations-local13',
//            '{{%option_values_translations}}',
//            'local',
//            '{{%languages}}',
//            'local',
//            'CASCADE');
//        $this->addForeignKey('fk-option_values_translations-option_id13',
//            '{{%option_values_translations}}',
//            'option_id',
//            '{{%option_values}}',
//            'id',
//            'CASCADE');
//
//        $this->addForeignKey('fk-order_products-order_id13', '{{%order_products}}', 'order_id', '{{%orders}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-order_products-product_id13', '{{%order_products}}', 'product_id', '{{%products}}', 'id');
//
//        $this->addForeignKey('fk-orders-delivery_id13', '{{%orders}}', 'delivery_id', '{{%shop_deliveries}}', 'id');
//        $this->addForeignKey('fk-orders-shop_id13', '{{%orders}}', 'shop_id', '{{%shops}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-orders-user_id13', '{{%orders}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-product_images-product_id113', '{{%product_images}}', 'product_id', '{{%products}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-product_options-option_id13', '{{%product_options}}', 'option_id', '{{%option_values}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-product_options-product_id13', '{{%product_options}}', 'product_id', '{{%products}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-product_performance_translations-local_113', '{{%product_performance_translations}}', 'local', '{{%languages}}', 'local', 'CASCADE');
//        $this->addForeignKey('fk-product_performance_translations-product_performance_id13', '{{%product_performance_translations}}', 'product_performance_id', '{{%product_performances}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-product_performances-product_id13', '{{%product_performances}}', 'product_id', '{{%products}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-product_translations-local_113', '{{%product_translations}}', 'local', '{{%languages}}', 'local', 'CASCADE');
//        $this->addForeignKey('fk-product_translations-product_id113', '{{%product_translations}}', 'product_id', '{{%products}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-products-category_id113', '{{%products}}', 'category_id', '{{%categories}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-products-sale_id3213', '{{%products}}', 'sale_id', '{{%sales}}', 'id');
//        $this->addForeignKey('fk-products-shop_id113', '{{%products}}', 'shop_id', '{{%shops}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-sales-shop_id2213', '{{%sales}}', 'shop_id', '{{%shops}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-shop_addresses-local_113', '{{%shop_addresses}}', 'local', '{{%languages}}', 'local', 'CASCADE');
//        $this->addForeignKey('fk-shop_addresses-shop_id13', '{{%shop_addresses}}', 'shop_id', '{{%shops}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-shop_deliveries-shop_id113', '{{%shop_deliveries}}', 'shop_id', '{{%shops}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-shop_delivery_translation-local_113', '{{%shop_delivery_translations}}', 'local', '{{%languages}}', 'local', 'CASCADE');
//        $this->addForeignKey('fk-shop_delivery_translation-shop_delivery_id13', '{{%shop_delivery_translations}}', 'shop_delivery_id', '{{%shop_deliveries}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-shops-seller_id13', '{{%shops}}', 'seller_id', '{{%sellers}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-static_page_category_translations-category_id13', '{{%static_page_category_translations}}', 'category_id', '{{%static_page_categories}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-static_page_category_translations-local13', '{{%static_page_category_translations}}', 'local', '{{%languages}}', 'local', 'CASCADE');
//
//        $this->addForeignKey('fk-static_page_translations-local13', '{{%static_page_translations}}', 'local', '{{%languages}}', 'local', 'CASCADE');
//        $this->addForeignKey('fk-static_page_translations-static_page_id13', '{{%static_page_translations}}', 'static_page_id', '{{%static_pages}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-static_pages-category_id13', '{{%static_pages}}', 'category_id', '{{%static_page_categories}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-user_addresses-user_id113', '{{%user_addresses}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-user_carts-product_id113', '{{%user_cart}}', 'product_id', '{{%products}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-user_carts-user_id113', '{{%user_cart}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-user_favorite-product_id13', '{{%user_favorite}}', 'product_id', '{{%products}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-user_favorite-user_id13', '{{%user_favorite}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
//
//        $this->addForeignKey('fk-user_recents-product_id13', '{{%user_recents}}', 'product_id', '{{%products}}', 'id', 'CASCADE');
//        $this->addForeignKey('fk-user_recents-user_id13', '{{%user_recents}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
//        $this->dropForeignKey('fk-auth-user_id-user-id13',
//            '{{%auth}}'
//        );
//
//        $this->dropForeignKey('fk-banner_translations-banner_id213',
//            '{{%banner_translations}}');
//        $this->dropForeignKey('fk-banner_translations-local213',
//            '{{%banner_translations}}');
//
//        $this->dropForeignKey('fk-brands-category_id113',
//            '{{%brands}}');
//
//        $this->dropForeignKey('fk-callbacks-shop_id13',
//            '{{%callbacks}}');
//
//        $this->dropForeignKey('fk-categories-parent_id13',
//            '{{%categories}}');
//
//        $this->dropForeignKey('fk-category_translations-category_id13',
//            '{{%category_translations}}');
//        $this->dropForeignKey('fk-category_translations-local_313',
//            '{{%category_translations}}');
//
//        $this->dropForeignKey('fk_message_source_message13',
//            '{{%message}}');
//
//        $this->dropForeignKey('fk-news_translations-local113',
//            '{{%news_translations}}');
//        $this->dropForeignKey('fk-news_translations-news_id113',
//            '{{%news_translations}}');
//
//        $this->dropForeignKey('fk-option_groups-category_id13',
//            '{{%option_groups}}');
//
//        $this->dropForeignKey('fk-option_group_translations-group_id13',
//            '{{%option_groups_translations}}');
//        $this->dropForeignKey('fk-option_group_translations-local13',
//            '{{%option_groups_translations}}');
//
//        $this->dropForeignKey('fk-option_values-group_id13',
//            '{{%option_values}}');
//
//        $this->dropForeignKey('fk-option_values_translations-local13',
//            '{{%option_values_translations}}');
//        $this->dropForeignKey('fk-option_values_translations-option_id13',
//            '{{%option_values_translations}}');
//
//        $this->dropForeignKey('fk-order_products-order_id13', '{{%order_products}}');
//        $this->dropForeignKey('fk-order_products-product_id13', '{{%order_products}}');
//
//        $this->dropForeignKey('fk-orders-delivery_id13', '{{%orders}}');
//        $this->dropForeignKey('fk-orders-shop_id13', '{{%orders}}');
//        $this->dropForeignKey('fk-orders-user_id13', '{{%orders}}');
//
//        $this->dropForeignKey('fk-product_images-product_id113', '{{%product_images}}');
//
//        $this->dropForeignKey('fk-product_options-option_id13', '{{%product_options}}');
//        $this->dropForeignKey('fk-product_options-product_id13', '{{%product_options}}');
//
//        $this->dropForeignKey('fk-product_performance_translations-local_113', '{{%product_performance_translations}}');
//        $this->dropForeignKey('fk-product_performance_translations-product_performance_id13', '{{%product_performance_translations}}');
//
//        $this->dropForeignKey('fk-product_performances-product_id13', '{{%product_performances}}');
//
//        $this->dropForeignKey('fk-product_translations-local_113', '{{%product_translations}}');
//        $this->dropForeignKey('fk-product_translations-product_id113', '{{%product_translations}}');
//
//        $this->dropForeignKey('fk-products-category_id113', '{{%products}}');
//        $this->dropForeignKey('fk-products-sale_id3213', '{{%products}}');
//        $this->dropForeignKey('fk-products-shop_id113', '{{%products}}');
//
//        $this->dropForeignKey('fk-sales-shop_id2213', '{{%sales}}');
//
//        $this->dropForeignKey('fk-shop_addresses-local_113', '{{%shop_addresses}}');
//        $this->dropForeignKey('fk-shop_addresses-shop_id13', '{{%shop_addresses}}');
//
//        $this->dropForeignKey('fk-shop_deliveries-shop_id113', '{{%shop_deliveries}}');
//
//        $this->dropForeignKey('fk-shop_delivery_translation-local_113', '{{%shop_delivery_translations}}');
//        $this->dropForeignKey('fk-shop_delivery_translation-shop_delivery_id13', '{{%shop_delivery_translations}}');
//
//        $this->dropForeignKey('fk-shops-seller_id13', '{{%shops}}');
//
//        $this->dropForeignKey('fk-static_page_category_translations-category_id13', '{{%static_page_category_translations}}');
//        $this->dropForeignKey('fk-static_page_category_translations-local13', '{{%static_page_category_translations}}');
//
//        $this->dropForeignKey('fk-static_page_translations-local13', '{{%static_page_translations}}');
//        $this->dropForeignKey('fk-static_page_translations-static_page_id13', '{{%static_page_translations}}');
//
//        $this->dropForeignKey('fk-static_pages-category_id13', '{{%static_pages}}');
//
//        $this->dropForeignKey('fk-user_addresses-user_id113', '{{%user_addresses}}');
//
//        $this->dropForeignKey('fk-user_carts-product_id113', '{{%user_cart}}');
//        $this->dropForeignKey('fk-user_carts-user_id113', '{{%user_cart}}');
//
//        $this->dropForeignKey('fk-user_favorite-product_id13', '{{%user_favorite}}');
//        $this->dropForeignKey('fk-user_favorite-user_id13', '{{%user_favorite}}');
//
//        $this->dropForeignKey('fk-user_recents-product_id13', '{{%user_recents}}');
//        $this->dropForeignKey('fk-user_recents-user_id13', '{{%user_recents}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180112_000951_cascade_foreign_keys cannot be reverted.\n";

        return false;
    }
    */
}
