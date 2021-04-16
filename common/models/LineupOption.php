<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_options".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $option_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OptionValue $option
 * @property Product $product
 */
class LineupOption extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lineup_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lineup_id', 'option_id'], 'required'],
            [['price'], 'number', 'min' => 0],
            [['lineup_id', 'option_id', 'created_at', 'updated_at'], 'integer'],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => OptionValue::className(), 'targetAttribute' => ['option_id' => 'id']],
            [['lineup_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lineup::className(), 'targetAttribute' => ['lineup_id' => 'id']],
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
            'product_id' => Yii::t('common', 'Product ID'),
            'option_id' => Yii::t('common', 'Option ID'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(OptionValue::className(), ['id' => 'option_id']);
    }
}
