<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "static_page_categories".
 *
 * @property integer $id
 * @property integer $order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property StaticPageCategoryTranslation[] $staticPageCategoryTranslations
 * @property StaticPage[] $staticPages
 */
class StaticPageCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_page_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'order' => 'Позиция',
            'status' => 'Статус',
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
    public function getStaticPageCategoryTranslations()
    {
        return $this->hasMany(StaticPageCategoryTranslation::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticPages()
    {
        return $this->hasMany(StaticPage::className(), ['category_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveStaticPages()
    {
        return $this->hasMany(StaticPage::className(), ['category_id' => 'id'])->where(['status' => 1])->orderBy('order');
    }

    public function getTranslate() {
        return ($this->hasOne(StaticPageCategoryTranslation::className(), ['category_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())? $this->hasOne(StaticPageCategoryTranslation::className(), ['category_id' => 'id'])->where(['local' => Language::getCurrent()->local]): $this->hasOne(StaticPageCategoryTranslation::className(), ['category_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }

    public static function getActive() {
        return parent::find()->where(['status' => 1])->orderBy('order')->all();
    }
}
