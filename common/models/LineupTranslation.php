<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_translations".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keys
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Language $local0
 * @property Product $product
 */
class LineupTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lineup_translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => 'create'],
            [['lineup_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'warranty'], 'string'],
            [['name', 'local'], 'string', 'max' => 255],

            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
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
            'lineup_id' => Yii::t('common', 'Product ID'),
            'name' => 'Модель Авто',
            'description' => 'Описание',
            'warranty' => 'Гарантия (Описание)',
            'local' => Yii::t('common', 'Local'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocal0()
    {
        return $this->hasOne(Language::className(), ['local' => 'local']);
    }
}
