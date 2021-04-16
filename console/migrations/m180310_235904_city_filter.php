<?php

use yii\db\Migration;

class m180310_235904_city_filter extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('cities', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'order' => $this->integer(11)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createTable('city_translations', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'city_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'local' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk-city_translations-city_id-cities-id2'
            , 'city_translations',
            'city_id',
            'cities',
            'id',
        'CASCADE'
        );

        $this->addColumn('shops', 'cities', $this->text());

        $city = new \common\models\City();
        $city->order = '0';
        $city->status = '1';
        $city->created_at = time();
        $city->updated_at = time();
        $city->save();

        $city_trans = new \common\models\CityTranslation();
        $city_trans->city_id = $city->id;
        $city_trans->name = 'Ташкент';
        $city_trans->local = 'ru-RU';
        $city_trans->created_at = time();
        $city_trans->updated_at = time();
        $city_trans->save();

        \common\models\Shop::updateAll(['cities' => json_encode([$city->id])]);

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-city_translations-city_id-cities-id2', 'city_translations');
        $this->dropTable('cities');
        $this->dropTable('city_translations');
        $this->dropColumn('shops', 'cities');
    }
}
