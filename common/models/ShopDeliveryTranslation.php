<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "shop_delivery_translations".
 *
 * @property integer $id
 * @property integer $shop_delivery_id
 * @property string $method
 * @property string $description
 * @property integer $schedule
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Language $local0
 * @property ShopDelivery $shopDelivery
 */
class ShopDeliveryTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_delivery_translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method', 'description', 'schedule'], 'required', 'on' => 'create'],
            [['shop_delivery_id', 'created_at', 'updated_at'], 'integer'],
            [['method', 'local', 'schedule'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
            [['shop_delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopDelivery::className(), 'targetAttribute' => ['shop_delivery_id' => 'id']],
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
            'shop_delivery_id' => Yii::t('common', 'Shop Delivery ID'),
            'method' => 'Метод',
            'description' => 'Описание',
            'schedule' => 'Режим',
            'local' => Yii::t('common', 'Local'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocal0()
    {
        return $this->hasOne(Language::className(), ['local' => 'local']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopDelivery()
    {
        return $this->hasOne(ShopDelivery::className(), ['id' => 'shop_delivery_id']);
    }
}
