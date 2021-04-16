<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "shop_deliveries".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $price
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Shop $shop
 * @property ShopDeliveryTranslation[] $shopDeliveryTranslations
 */
class ShopDelivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_deliveries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'required'],
            [['shop_id', 'price', 'status', 'created_at', 'updated_at'], 'integer'],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
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
            'price' => 'Цена',
            'status' => 'Статус',
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
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopDeliveryTranslations()
    {
        return $this->hasMany(ShopDeliveryTranslation::className(), ['shop_delivery_id' => 'id']);
    }

    public function getShowPrice()
    {
        return number_format($this->price, 0, '', ' ').' '.Yii::t('frontend', 'Currency');
    }

    public function getTranslate() {
        return ($this->hasOne(ShopDeliveryTranslation::className(), ['shop_delivery_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
            $this->hasOne(ShopDeliveryTranslation::className(), ['shop_delivery_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
            $this->hasOne(ShopDeliveryTranslation::className(), ['shop_delivery_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
