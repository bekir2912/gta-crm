<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "option_values".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $price
 * @property integer $order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OptionGroup $group
 * @property OptionValuesTranslation[] $OptionValuesTranslation
 * @property ProductOption[] $ProductOption
 */
class OptionValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'], 'required'],
            [['image'], 'string', 'max' => 255],
            [['group_id',  'order', 'status', 'created_at', 'updated_at'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OptionGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'group_id' => 'Группа',
            'order' => 'Позиция',
            'image' => 'Иконка',
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
    public function getGroup()
    {
        return $this->hasOne(OptionGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptionValuesTranslation()
    {
        return $this->hasMany(OptionValuesTranslation::className(), ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductOption()
    {
        return $this->hasMany(ProductOption::className(), ['option_id' => 'id']);
    }

    public function getTranslate() {
        return
            ($this->hasOne(OptionValuesTranslation::className(), ['option_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
                $this->hasOne(OptionValuesTranslation::className(), ['option_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
                $this->hasOne(OptionValuesTranslation::className(), ['option_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
