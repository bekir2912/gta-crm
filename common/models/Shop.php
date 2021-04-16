<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "shops".
 *
 * @property integer $id
 * @property integer $seller_id
 * @property string $name
 * @property string $image
 * @property integer $order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product[] $Product
 * @property Seller $seller
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shops';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', /*'image', 'logo'*/], 'required', 'on' => 'create'],
            [['seller_id', 'order', 'online_pay', 'top', 'top_order', 'on_main', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'image', 'certificate', 'logo', 'url'], 'string', 'min' => 2, 'max' => 255],
            [['payments','cities'], 'string'],
            [['legal_name',
                'trademark',
                'legal_address',
                'physical_address',
                'legal_phone',
                'rs',
                'bank',
                'bank_city',
                'mfo',
                'inn',
                'okonh',
            ], 'string', 'max' => 500],
            ['rating', 'double'],
            [['service'], 'number', 'min' => 0, 'max' => 100],

//            ['image', 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, png', 'maxSize' => 1024 * 1024 * 2],
//            ['logo', 'image', 'extensions' => 'jpg, jpeg, png', 'maxSize' => 1024 * 1024 * 2],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seller::className(), 'targetAttribute' => ['seller_id' => 'id']],
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
            'id' => 'ID',
            'seller_id' => 'ID юр.лица',
            'name' => 'Название',
            'image' => 'Фото',
            'logo' => 'Лого',
            'certificate' => 'Свидетельство',
            'licence' => 'Лицензия',
            'online_pay' => 'Онлайн оплата',
            'order' => 'Позиция',
            'top_order' => 'Позиция в топе',
            'status' => 'Статус',
            'rating' => 'Рейтинг',
            'top' => 'В топ',
            'on_main' => 'На главной',
            'service' => 'Комиссия',
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),

            'legal_name' => 'Юридическое название',
            'trademark' => 'Торговая марка',
            'legal_address' => 'Юридический адрес',
            'physical_address' => 'Фактический адрес',
            'legal_phone' => 'Телефон',
            'rs' => 'Расчетный счёт',
            'bank' => 'Наименование банка',
            'bank_city' => 'Город',
            'mfo' => 'МФО',
            'inn' => 'ИНН',
            'okonh' => 'Оконх',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['shop_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(ShopReview::className(), ['shop_id' => 'id']);
    }
    /**
     * @return int
     */
    public function getReviewsCount()
    {
        return ShopReview::find()->where(['status' => 1, 'shop_id' => $this->id])->count();
    }
    /**
     * @return int
     */
    public function getRate()
    {
        return round(Order::find()->where(['comment_status' => 1, 'shop_id' => $this->id])->average('comment_rate'), 1);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasMany(ShopDelivery::className(), ['shop_id' => 'id'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['id' => 'seller_id']);
    }

    public function getInfo() {
        return ($this->hasOne(ShopAddresses::className(), ['shop_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
            $this->hasOne(ShopAddresses::className(), ['shop_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
            $this->hasOne(ShopAddresses::className(), ['shop_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
