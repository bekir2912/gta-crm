<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "company_expenses".
 *
 * @property integer $id
 * @property string $name
 * @property string $discription
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Expenses[] $expenses
 */
class ExpensesCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expenses_categories';
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
            [['name'], 'required'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'discription'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование расхода',
            'discription' => 'Описание расхода',
            'status' => 'Статус расхода',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getExpenses(){
        return $this->hasOne(Expenses::className(), ['сategories_exp_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getExpenses()
    // {
    //     return $this->hasMany(Expenses::className(), ['company_exp_id' => 'id']);
    // }
}
