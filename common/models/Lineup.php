<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $category_id
 * @property integer $price
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 *
 * @property ProductImages[] $productImages
 * @property LineupTranslation[] $LineupTranslation
 * @property Category $category
 * @property Shop $shop
 */
class Lineup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lineups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id','price'], 'required'],
            [['year'], 'integer', 'max' => date('Y'), 'min' => 1900],
            [['price'], 'number'],
            [['brand_id', 'category_id',  'status', 'warranty', 'created_at', 'client_id', 'updated_at'], 'integer'],
            [['mileage', 'auto_number'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'category_id' => 'Категория машины',
            'brand_id' => 'Марка',
            'client_id' => 'Хозяин машины',
            'warranty' => 'Гарантия (мес)',
            'price' => 'Цена',
            'mileage'=> 'Пробег',
            'auto_number'=> 'Гос номер авто',
            'year' => 'Год',
            'logo' => 'Фото',
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
        return parent::find()->with('translate')
            ->with('brand')
            ->with('mainImage')
            ->with('productImages')
            ->with('otherImages')
            ->with('activeOptions');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::className(), ['product_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtherImages()
    {
        return $this->hasMany(ProductImages::className(), ['product_id' => 'id'])->andWhere(['!=', 'main', 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(ProductImages::className(), ['product_id' => 'id'])->where(['main' => 1]);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineupTranslation()
    {
        return $this->hasMany(LineupTranslation::className(), ['lineup_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }


    public function getTranslate() {
        return ($this->hasOne(LineupTranslation::className(), ['lineup_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())? $this->hasOne(LineupTranslation::className(), ['lineup_id' => 'id'])->where(['local' => Language::getCurrent()->local]): $this->hasOne(LineupTranslation::className(), ['lineup_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }


    public function getActiveOptions()
    {
        return $this->hasMany(LineupOption::className(), ['lineup_id' => 'id']);
    }




    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }


    public function getCategories()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
}
