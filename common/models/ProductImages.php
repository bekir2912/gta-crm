<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_images".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $image
 * @property integer $main
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product $product
 * @property Lineup $lineup

 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id', 'main', 'created_at', 'updated_at'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lineup::className(), 'targetAttribute' => ['product_id' => 'id']],

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
            'image' => Yii::t('common', 'Image'),
            'main' => Yii::t('common', 'Main'),
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
    public function getLineup()
    {
        return $this->hasOne(Lineup::className(), ['id' => 'product_id']);
    }
}
