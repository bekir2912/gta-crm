<?php
namespace frontend\models;

use common\models\Order;
use common\models\OrderProduct;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class ReviewForm extends Model
{
    public $id;
    public $rate;
    public $review;
    public $type;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['rate', 'trim'],
            ['rate', 'required'],

            ['id', 'trim'],
            ['id', 'required'],

            ['rate', 'in', 'range' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]],

            ['review', 'trim'],
            ['review', 'required'],
            ['review', 'string', 'min' => 2],

            ['type', 'trim'],
            ['type', 'required'],
            ['type', 'in', 'range' => ['product', 'shop']],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rate' => Yii::t('frontend', 'Rating'),
            'review' => Yii::t('frontend', 'Review'),
        ];
    }

    public function updateReview()
    {
        if (!$this->validate()) {
            return null;
        }
        if($this->type == 'shop') {
            $shop = Order::findOne(['id' => $this->id, 'user_id' => Yii::$app->user->id, 'status' => 1]);
            if(!$shop) return false;
            if($shop->comment_status == 1) return false;
            $shop->comment_rate = $this->rate;
            $shop->comment_status = 0;
            $shop->comment = $this->review;
            return $shop->save() ? $shop : null;
        }
        if($this->type == 'product') {
            $product = OrderProduct::findOne(['id' => $this->id]);
            if(!$product) return false;
            if($product->comment_status == 1) return false;
            if($product->order->status == 0) return false;
            if($product->order->user_id != Yii::$app->user->id) return false;
            $product->comment_rate = $this->rate;
            $product->comment_status = 0;
            $product->comment = $this->review;
            return $product->save() ? $product : null;
        }

        return null;
    }
}
