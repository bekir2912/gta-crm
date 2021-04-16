<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_reviews`.
 */
class m181114_132449_create_shop_reviews_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('shop_reviews', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'shop_id' => $this->integer(11)->notNull(),
            'rating' => $this->double()->defaultValue(0),
            'comment' => $this->text(),
            'status' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ],$tableOptions);
        $this->addForeignKey('fk-shop_reviews-user_id-user-id',
            'shop_reviews',
            'user_id',
            'user',
            'id',
            'CASCADE');
        $this->addForeignKey('fk-shop_reviews-shop_id-shops-id',
            'shop_reviews',
            'shop_id',
            'shops',
            'id',
            'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('shop_reviews');
    }
}
