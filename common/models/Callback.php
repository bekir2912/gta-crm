<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "callbacks".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property string $name
 * @property string $phone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Shop $shop
 */
class Callback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'callbacks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'name', 'phone'], 'required'],
            [['shop_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'shop_id' => Yii::t('common', 'Shop ID'),
            'name' => 'ФИО',
            'phone' => 'Номер',
            'status' => 'Статус',
            'created_at' => 'Дата',
//            'updated_at' => Yii::t('common', 'Updated At'),
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
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }
}
