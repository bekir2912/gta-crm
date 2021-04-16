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
 * @property ProductImages[] $productImages
 * @property ProductTranslation[] $ProductTranslation
 * @property Category $category
 * @property Shop $shop
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'price'], 'required'],
            [['add_cats', 'add_cats_titles', 'currency', 'type'], 'string'],
            [['articul'], 'string'],
            [['price_usd'], 'number', 'min' => 0],
            [['price', 'km'], 'safe'],
            [['from', 'phone_views'], 'integer','min' => 0],
            [['year'], 'integer', 'max' => date('Y'), 'min' => 1900],
            [['wholesale', 'in_order', 'custom_options'], 'safe'],
            [['wholesale_unit_id', 'is_moderated'], 'safe'],
            [['shop_id', 'category_id', 'brand_id','user_id', 'lineup_id',  'price_type', 'unit_id', 'sale_id', 'status', 'warranty',  'interesting',  'interesting_order',  'view', 'created_at', 'updated_at'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'shop_id' => 'Компания',
            'user_id' => 'Пол-ль',
            'unit_id' => 'за...',
            'type' => Yii::t('frontend', 'Anounce type'),
            'currency' => Yii::t('frontend', 'Currency'),
            'brand_id' => Yii::t('frontend', 'Brand'),
            'category_id' => Yii::t('frontend', 'Category'),
            'lineup_id' => Yii::t('frontend', 'Lineup'),
            'status' => Yii::t('frontend', 'Status'),
            'from' => Yii::t('frontend', 'Price From'),
            'warranty' => 'Гарантия (мес)',
            'articul' => '№ объявления',
            'km' => Yii::t('frontend', 'mileage'),
            'year' => Yii::t('frontend', 'year'),
            'price_usd' => Yii::t('frontend', 'Product Price'),
//            'price' => Yii::t('frontend', 'Product Price'),
            'price' => Yii::t('frontend', 'Price'),
            'price_type' => Yii::t('frontend', 'Type'),
            'sale_id' => 'Скидка',
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
            ->with('category')
            ->with('mainImage')
            ->with('productImages')
            ->with('otherImages')
            ->with('sale')
            ->with('shop')
            ->with('unit')
            ->with('brand')
            ->with('shopIsActive')
            ->with('activeOptions')
            ->with('performances');
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
    public function getProductTranslation()
    {
        return $this->hasMany(ProductTranslation::className(), ['product_id' => 'id']);
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
    public function getMainImage()
    {
        return $this->hasOne(ProductImages::className(), ['product_id' => 'id'])->where(['main' => 1]);
    }

    public function getWholesale() {
        $currency = Yii::$app->session->get('currency', 'uzs');
        if($currency == 'usd') {
            $this->wholesale = $this->wholesale_usd;
        }

        return $this->wholesale;
    }

    public function getShowPrice()
    {
        $currency = Yii::$app->session->get('currency', 'uzs');
        if($currency == 'usd') {
            $this->price = $this->price_usd;
        }
        if($this->price == 0) {
            return '';
        }
        if(preg_match('/\./i', $this->price)) {
            $price = number_format($this->price, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
        }
        else {
            $price = number_format($this->price, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
        }

        $prefix = '';
        if($this->from == 1) {
            $prefix = Yii::t('frontend', 'From').' ';
        }

        $price = preg_replace('/,00$/i', '', $price);
        return $prefix.$price.' <small>'.Yii::t('frontend', $currency).'</small>';
    }

    public function getApiPrice($currency)
    {
        if($currency == 'usd') {
            $this->price = $this->price_usd;
        }
        if($this->price == 0) {
            return Yii::t('frontend', 'Specify prices from the seller');
        }
        $price = number_format($this->price, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);

        $prefix = '';
        if($this->from == 1) {
            $prefix = Yii::t('frontend', 'From').' ';
        }

        return $prefix.$price.' '.Yii::t('frontend', $currency);
    }

    /**
     * @return string
     */
    public function getWarrantyValue()
    {
        if($this->warranty >= 12) {
            $year = $this->warranty / 12;
            if(is_int($year)) return $year.' '.Yii::t('frontend', 'Year');
            $month = $this->warranty - (floor($year) * 12);
            return floor($year).' '.Yii::t('frontend', 'Year').' '.$month.' '.Yii::t('frontend', 'Month');
        }
        else {
            return $this->warranty.Yii::t('frontend', 'Month');
        }
    }


    /**
     * @return int|string
     */
    public function getReviewsCount()
    {
        return OrderProduct::find()->where(['comment_status' => 1, 'product_id' => $this->id])->count();
    }
    /**
     * @return int
     */
    public function getRate()
    {
        return round(OrderProduct::find()->where(['comment_status' => 1, 'product_id' => $this->id])->average('comment_rate'), 1);
    }

    public function getSalePrice()
    {
        if($this->price == 0) {
            return '';
        }
        if($this->sale->type == 1) {
            $price = $this->price - $this->sale->value;
        }
        else {
            $price = $this->price - ($this->price * $this->sale->value);
        }

        if(preg_match('/\./i', $this->price)) {
            $price = number_format($price, Yii::$app->params['price_dec']['decimals'], Yii::$app->params['price_dec']['dec_pointer'], Yii::$app->params['price_dec']['thousands_sep']);
        }
        else {
            $price = number_format($price, Yii::$app->params['price']['decimals'], Yii::$app->params['price']['dec_pointer'], Yii::$app->params['price']['thousands_sep']);
        }

        $prefix = '';
        if($this->from == 1) {
            $prefix = Yii::t('frontend', 'From').' ';
        }

        $price = preg_replace('/,00$/i', '', $price);
        return $prefix.$price.' <small>'.Yii::t('frontend', 'Currency').'</small>';
    }

    public function getSale()
    {
        return $this->hasOne(Sale::className(), ['id' => 'sale_id'])->where('`status` = 1 AND `expire_till` > '.time());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineup()
    {
        return $this->hasOne(Lineup::className(), ['id' => 'lineup_id']);
    }


    public function getShopIsActive()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id'])->where(['status' => 1]);
    }

    public function getTranslate() {
        return ($this->hasOne(ProductTranslation::className(), ['product_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())? $this->hasOne(ProductTranslation::className(), ['product_id' => 'id'])->where(['local' => Language::getCurrent()->local]): $this->hasOne(ProductTranslation::className(), ['product_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }


    public function getActiveOptions()
    {
        return $this->hasMany(ProductOption::className(), ['product_id' => 'id']);
    }

    public function getPerformances()
    {
        return $this->hasMany(ProductPerformance::className(), ['product_id' => 'id']);
    }
}
