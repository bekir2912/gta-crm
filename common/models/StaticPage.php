<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "static_pages".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $url
 * @property integer $external
 * @property integer $order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property StaticPageTranslation[] $staticPageTranslations
 * @property StaticPageCategory $category
 */
class StaticPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'external', 'order','on_top', 'status', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 255],
            ['url', 'unique', 'targetClass' => '\common\models\StaticPage', 'message' => 'Это не уникальный url.'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticPageCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'url' => 'Ссылка',
            'external' => 'Открывать в новом окне',
            'order' => 'Позиция',
            'status' => 'Статус',
            'on_top' => 'В верхнем меню',
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
    public function getStaticPageTranslations()
    {
        return $this->hasMany(StaticPageTranslation::className(), ['static_page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(StaticPageCategory::className(), ['id' => 'category_id']);
    }

    public function getTranslate() {
        return ($this->hasOne(StaticPageTranslation::className(), ['static_page_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())? $this->hasOne(StaticPageTranslation::className(), ['static_page_id' => 'id'])->where(['local' => Language::getCurrent()->local]): $this->hasOne(StaticPageTranslation::className(), ['static_page_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }

    public static function getActive() {
        return parent::find()->where(['status' => 1])->orderBy('order')->all();
    }
}
