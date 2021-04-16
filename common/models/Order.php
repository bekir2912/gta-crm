<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property double $service
 * @property integer $delivery_id
 * @property integer $user_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property integer $pay_method
 * @property integer $sum
 * @property integer $comment_status
 * @property integer $comment_rate
 * @property string $comment
 * @property integer $pay_status
 * @property integer $pay_amount
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderProduct[] $OrderProduct
 * @property ShopDelivery $delivery
 * @property Shop $shop
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
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
    public function rules()
    {
        return [
            [['shop_id', 'user_id', 'sum'], 'required'],
            [['shop_id', 'delivery_id', 'user_id', 'which_pay', 'pay_method','comment_status', 'comment_rate', 'pay_status', 'pay_amount', 'status', 'created_at', 'updated_at'], 'integer'],
            [['service'], 'number'],
            [[ 'sum', 'pay_amount'], 'number', 'min' => 0],
            [['address', 'comment'], 'string'],
            [['name', 'phone', 'email'], 'string', 'max' => 255],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopDelivery::className(), 'targetAttribute' => ['delivery_id' => 'id']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'service' => 'Комиссия (%)',
            'delivery_id' => 'Доставка',
            'user_id' => Yii::t('common', 'User ID'),
            'name' => 'ФИО',
            'phone' => Yii::t('common', 'Phone'),
            'email' => Yii::t('common', 'Email'),
            'address' => Yii::t('common', 'Address'),
            'pay_method' => 'Способ оплаты',
            'sum' => 'Сумма',
            'comment_status' => Yii::t('common', 'Comment Status'),
            'comment_rate' => 'Оценка',
            'comment' => 'Отзыв',
            'pay_status' => 'Оплачено',
            'pay_amount' => Yii::t('common', 'Pay Amount'),
            'status' => 'Статус',
            'created_at' => 'Дата',
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProduct()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(ShopDelivery::className(), ['id' => 'delivery_id']);
    }

    public function getCheckStatus()
    {
        if($this->status == -1) return 1;
        if($this->status == 1) {
            if($this->delivery_id == 0) {
                if($this->pay_method == 0) return 3;
                if($this->pay_status == 1) return 3;
                return 2;
            }
            if($this->pay_method == 0) return 4;
            if($this->pay_status == 1) return 4;
            return 2;
        }
        return 0;
    }

    public function getIsComplete() {
        return ($this->getCheckStatus() == 3 || $this->getCheckStatus() == 4)? true: false;
    }

    public function getCanCancel() {
        return ($this->getCheckStatus() == 0)? true: false;
    }

    public function getCanReview() {
        if(!$this->getIsComplete()) return false;
        return ($this->comment_status == 0)? true: false;
    }

    public function getCanPay() {
        return ($this->getCheckStatus() == 2)? true: false;
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getShowPrice()
    {
        if(preg_match('/\./i', $this->sum)) {
            $price = number_format($this->sum, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
        }
        else {
            $price = number_format($this->sum, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
        }

        $price = preg_replace('/,00$/i', '', $price);
        return $price.' '.Yii::t('frontend', 'Currency');
    }

    public function getShowCommission()
    {
        if(preg_match('/\./i', $this->sum)) {
            $price = number_format($this->sum * $this->shop->service / 100, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
        }
        else {
            $price = number_format($this->sum * $this->shop->service / 100, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
        }

        $price = preg_replace('/,00$/i', '', $price);
        return $price.' '.Yii::t('frontend', 'Currency');
    }
}
