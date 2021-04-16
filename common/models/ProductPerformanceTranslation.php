<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_performance_translations".
 *
 * @property integer $id
 * @property integer $product_performance_id
 * @property string $name
 * @property string $description
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Language $local0
 * @property ProductPerformance $productPerformance
 */
class ProductPerformanceTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_performance_translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_performance_id', 'name', 'local'], 'required'],
            [['product_performance_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'local'], 'string', 'max' => 255],
            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
            [['product_performance_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductPerformance::className(), 'targetAttribute' => ['product_performance_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'product_performance_id' => Yii::t('common', 'Product Performance ID'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'local' => Yii::t('common', 'Local'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocal0()
    {
        return $this->hasOne(Language::className(), ['local' => 'local']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPerformance()
    {
        return $this->hasOne(ProductPerformance::className(), ['id' => 'product_performance_id']);
    }
}
