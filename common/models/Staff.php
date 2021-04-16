<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $FIO
 * @property string $position
 * @property string $birthday
 * @property double $salary
 * @property string $phone
 * @property string $adress
 * @property string $status
 * @property string $created_at
 * @property string $images
 *
 * @property Clients[] $clients
 */


class Staff extends \yii\db\ActiveRecord



{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    
    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    
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
            [['FIO'], 'required'],
            [['birthday'], 'date', 'format' => 'yyyy-MM-dd'],
         
            [['created_at'], 'safe'],
            [['salary'], 'number'],
            [['status'], 'string'],
            [['FIO', 'position', 'phone', 'adress', 'images'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'FIO' => 'ФИО',
            'position' => 'Должность',
            'birthday' => 'Дата рождения',
            'salary' => 'Зарплата',
            'phone' => 'Номер телефона',
            'adress' => 'Адресс',
            'status' => 'статус',
            'created_at' => 'Дата добавления',
            'images' => 'Фото',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['staff_id' => 'id']);
    }
}
