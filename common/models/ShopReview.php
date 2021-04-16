<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat".
 *
 * @property string $id
 * @property string $user_id
 * @property string $shop_id
 * @property integer $direction
 * @property string $message
 * @property integer $type
 * @property integer $is_read
 * @property string $created_at
 * @property string $updated_at
 */
class ShopReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rating', 'comment'], 'required'],
            [['user_id', 'rating', 'shop_id'], 'integer'],
            [['comment'], 'string'],
            [['created_at', 'updated_at', 'status', 'is_moderated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'shop_id' => 'Компания',
            'rating' => 'Рейтинг',
            'comment' => 'Отзыв',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }


}
