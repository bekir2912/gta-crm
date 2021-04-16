<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "option_values".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property UnitTranslation[] $UnitTranslation
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'units';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'status' => 'Статус',
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

    public static function find() {
        return parent::find()->with('translate');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitTranslation()
    {
        return $this->hasMany(UnitTranslation::className(), ['unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getName()
    {
        return $this->translate->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFullName()
    {
//        return ($this->translate->full_name != '')? $this->translate->full_name: $this->translate->name;
        return $this->translate->name;
    }

    public function getTranslate() {
        return
            ($this->hasOne(UnitTranslation::className(), ['unit_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
                $this->hasOne(UnitTranslation::className(), ['unit_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
                $this->hasOne(UnitTranslation::className(), ['unit_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
