<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $category_id
 * @property integer $price
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductImages[] $productImages
 * @property LineupTranslation[] $LineupTranslation
 * @property Category $category
 * @property Shop $shop
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'answer', 'question_id'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['is_read', 'is_moderated', 'file'], 'safe'],
        ];
    }

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
            'user_id' => 'Пользователь',
            'warranty' => 'Тема',
        ];
    }

    public static function find() {
        return parent::find()
            ->with('user');
    }

    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
