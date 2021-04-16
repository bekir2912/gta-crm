<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sales".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property string $name
 * @property double $value
 * @property string $expire_till
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product[] $Product
 * @property Shop $shop
 */
class Sale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','expire_till', 'value'], 'required'],
            [['shop_id',  'status', 'created_at', 'updated_at', 'type'], 'integer'],
            [['value'], 'number', 'min' => 0],
            [['expire_till','name'], 'string', 'max' => 255],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'shop_id' => Yii::t('common', 'Shop ID'),
            'name' => 'Название',
            'value' => 'Размер скидки',
            'type' => 'Тип',
            'expire_till' => 'Дейсвует до',
            'status' => 'Статус',
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['sale_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    public function getPercentage()
    {
        return ($this->value * 100).'%';
    }
}
