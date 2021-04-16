<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "static_page_translations".
 *
 * @property integer $id
 * @property integer $static_page_id
 * @property string $name
 * @property string $text
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keys
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Language $local0
 * @property StaticPage $staticPage
 */
class StaticPageTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_page_translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => 'create'],
            [['static_page_id', 'created_at', 'updated_at'], 'integer'],
            [['text', 'meta_description', 'meta_keys'], 'string'],
            [['name', 'meta_title', 'local'], 'string', 'max' => 255],
            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
            [['static_page_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticPage::className(), 'targetAttribute' => ['static_page_id' => 'id']],
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
            'static_page_id' => Yii::t('common', 'Static Page ID'),
            'name' => 'Название',
            'text' => 'Текст',
            'meta_title' => 'SEO Название',
            'meta_description' => 'SEO Описание',
            'meta_keys' => 'SEO Ключи',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticPage()
    {
        return $this->hasOne(StaticPage::className(), ['id' => 'static_page_id']);
    }
}
