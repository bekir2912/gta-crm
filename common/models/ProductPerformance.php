<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_performances".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductPerformanceTranslation[] $ProductPerformanceTranslation
 * @property Product $product
 */
class ProductPerformance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_performances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'created_at', 'updated_at'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }


    public static function find() {
        return parent::find()->with('translate');
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
    public function getProductPerformanceTranslation()
    {
        return $this->hasMany(ProductPerformanceTranslation::className(), ['product_performance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getTranslate() {
        return ($this->hasOne(ProductPerformanceTranslation::className(), ['product_performance_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
            $this->hasOne(ProductPerformanceTranslation::className(), ['product_performance_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
            $this->hasOne(ProductPerformanceTranslation::className(), ['product_performance_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
