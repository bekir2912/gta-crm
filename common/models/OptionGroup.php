<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "option_groups".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OptionGroupsTranslation[] $OptionGroupsTranslation
 * @property Category $category
 * @property OptionValue[] $OptionValue
 */
class OptionGroup extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'order', 'status', 'type', 'range', 'main', 'created_at', 'updated_at'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'category_id' => 'Категория',
            'type' => 'Мультивыборочный',
            'main' => 'Основной',
            'order' => 'Позиция',
            'status' => 'Статус',
            'range' => 'Фильтр от-до',
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    public static function find() {
        return parent::find()->with('translate');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptionGroupTranslation()
    {
        return $this->hasMany(OptionGroupsTranslation::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptionValue()
    {
        return $this->hasMany(OptionValue::className(), ['group_id' => 'id']);
    }

    public function getTranslate() {
        return
            ($this->hasOne(OptionGroupsTranslation::className(), ['group_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
                $this->hasOne(OptionGroupsTranslation::className(), ['group_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
                $this->hasOne(OptionGroupsTranslation::className(), ['group_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }


    public function getActiveOptions()
    {
        return $this->hasMany(OptionValue::className(), ['group_id' => 'id'])->where(['status' => 1])->orderBy('order');
    }
}
