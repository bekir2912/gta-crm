<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Class City
 * @package common\models
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'status', 'created_at', 'updated_at'], 'integer'],
            [['lat', 'lng', 'address'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'order' => 'Позиция',
            'status' => 'Статус',
            'address' => 'Укажите центр города',
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function find() {
        return parent::find()->with('translate');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityTranslation()
    {
        return $this->hasMany(CityTranslation::className(), ['city_id' => 'id']);
    }

    public function getTranslate() {
        return ($this->hasOne(CityTranslation::className(), ['city_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
            $this->hasOne(CityTranslation::className(), ['city_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
            $this->hasOne(CityTranslation::className(), ['city_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
