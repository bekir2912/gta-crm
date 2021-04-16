<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_recents".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product $product
 * @property User $user
 */
class UserRecent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_recents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'user_id' => Yii::t('common', 'User ID'),
            'product_id' => Yii::t('common', 'Product ID'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @return void
     */
    public static function addProduct($id) {
        if(empty($isset = UserRecent::findOne(['user_id' => Yii::$app->user->id, 'product_id' => $id]))) {
            $userRecent = new UserRecent();
            $userRecent->product_id = $id;
            $userRecent->user_id = Yii::$app->user->id;
            $userRecent->save();
        }
//        if(UserRecent::find()->where(['user_id' => Yii::$app->user->id])->count() >= Yii::$app->params['recent_count']) {
//            $min_id = UserRecent::find()->andWhere(['user_id' => Yii::$app->user->id])->min('id');
//            UserRecent::deleteAll(['id' => $min_id]);
//        }
    }
}
