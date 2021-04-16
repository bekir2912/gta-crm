<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $url
 * @property string $icon
 * @property integer $on_main
 * @property integer $order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property CategoryTranslation[] $CategoryTranslation
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'on_main', 'order', 'status', 'created_at', 'updated_at'], 'integer'],
            [['url', 'icon'], 'string', 'max' => 255],
            [['view', 'spec'], 'integer'],
//            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'parent_id' => 'Категория',
            'url' => Yii::t('common', 'Url'),
            'icon' => 'Иконка',
            'spec' => 'Запчасти',
            'on_main' => 'Услуги',
            'order' => 'Позиция',
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

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->cacheFrontend->delete('menu_main_ru-RU');
        Yii::$app->cacheFrontend->delete('menu_main_render_ru-RU');
        Yii::$app->cacheFrontend->delete('menu_main_en-EN');
        Yii::$app->cacheFrontend->delete('menu_main_render_en-EN');
        Yii::$app->cacheFrontend->delete('menu_main_uz-UZ');
        Yii::$app->cacheFrontend->delete('menu_main_render_uz-UZ');
        parent::afterSave($insert, $changedAttributes);
    }

    public static function find() {
        return parent::find()->with('translate');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryTranslation()
    {
        return $this->hasMany(CategoryTranslation::className(), ['category_id' => 'id']);
    }

    public function getActiveCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id'])->where(['status' => 1])->orderBy('order')->with('translate');
    }

    public function getTranslate() {
        return ($this->hasOne(CategoryTranslation::className(), ['category_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())? $this->hasOne(CategoryTranslation::className(), ['category_id' => 'id'])->where(['local' => Language::getCurrent()->local]): $this->hasOne(CategoryTranslation::className(), ['category_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }

    public function getLineup()
    {
        return $this->hasMany(Lineup::className(), ['category_id' => 'id']);
    }
}
