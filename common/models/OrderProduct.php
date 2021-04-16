<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_Product".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $options
 * @property integer $price
 * @property integer $amount
 * @property integer $sum
 * @property integer $comment_status
 * @property integer $comment_rate
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order $order
 * @property Product $product
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_products';
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
            [['order_id', 'product_id', 'price', 'amount', 'sum'], 'required'],
            [['order_id', 'product_id', 'amount',  'comment_status', 'comment_rate', 'created_at', 'updated_at'], 'integer'],
            [['options', 'comment'], 'string'],
            [['price', 'sum', 'sale', 'sale_type'], 'number', 'min' => 0],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'order_id' => Yii::t('common', 'Order ID'),
            'product_id' => Yii::t('common', 'Product ID'),
            'options' => Yii::t('common', 'Options'),
            'price' => Yii::t('common', 'Price'),
            'amount' => Yii::t('common', 'Amount'),
            'sum' => Yii::t('common', 'Sum'),
            'comment_status' => Yii::t('common', 'Comment Status'),
            'comment_rate' => 'Оценка',
            'comment' => Yii::t('common', 'Comment'),
            'created_at' => 'Дата',
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getShowPrice()
    {
        if(preg_match('/\./i', $this->price)) {
            $price = number_format($this->price, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
        }
        else {
            $price = number_format($this->price, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
        }

        $price = preg_replace('/,00$/i', '', $price);
        return $price.' '.Yii::t('frontend', 'Currency');
    }

    public function getShowSum()
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
}
