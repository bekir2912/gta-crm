<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "expenses".
 *
 * @property integer $id
 * @property integer $exp_id
 * @property string $name
 * @property double $price
 * @property string $discription
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 *
 * @property ExpensesCategories $exp
 * @property Report[] $reports
 */
class Expenses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expenses';
    }


    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exp_id', 'status'], 'integer'],
            [['name', 'price', 'status'], 'required'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'discription'], 'string', 'max' => 255],
            [['exp_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExpensesCategories::className(), 'targetAttribute' => ['exp_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exp_id' => 'Тип расхода',
            'name' => 'Наименование расхода',
            'price' => 'Цена расхода',
            'discription' => 'Описание расхода',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновлния',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExp()
    {
        return $this->hasOne(ExpensesCategories::className(), ['id' => 'exp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['cost_id' => 'id']);
    }
}
