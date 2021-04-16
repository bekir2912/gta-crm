<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property integer $staff_id
 * @property string $is_seller
 * @property string $FIO
 * @property string $phone
 * @property string $pasport_serial
 * @property string $registration
 * @property string $brithsday
 * @property string $status
 * @property string $created_date
 *
 * @property Staff $staff
 */
class Clients extends \yii\db\ActiveRecord
{

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
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
            [['staff_id'], 'integer'],
            [['is_seller', 'status'], 'string'],
            [['FIO'], 'required', 'message' => 'Заполните поле'],
            [['created_at'], 'safe'],
            [['FIO', 'pasport_serial', 'phone', 'registration', 'brithsday'], 'string', 'max' => 255],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Кто привел из сотрудников',
            'is_seller' => 'Статус клиента (продовец/ покупатель)',
            'FIO' => 'ФИО',
            'phone' => 'Номер телефона',
            'pasport_serial' => 'Серия паспорта',
            'registration' => 'Место проживания',
            'brithsday' => 'дата рождения',
            'status' => 'статус',
            'created_at' => Yii::t('common', 'дата создания'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    public function getLineup()
    {
        return $this->hasMany(Lineup::className(), ['client_id' => 'id']);
    }
}
