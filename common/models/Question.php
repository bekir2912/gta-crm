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
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'question'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            ['is_moderated', 'safe'],
            ['file', 'safe'],
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

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }
    public function getNewAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id'])->where(['is_moderated' => 0]);
    }
    public function getAnswersCount()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id'])->count();
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
