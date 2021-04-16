<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news_translations".
 *
 * @property integer $id
 * @property integer $news_id
 * @property string $name
 * @property string $short
 * @property string $text
 * @property string $image
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keys
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Language $local0
 * @property News $news
 */
class NewsTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => 'create'],
            [['news_id', 'created_at', 'updated_at'], 'integer'],
            [['short', 'text', 'meta_description', 'meta_keys'], 'string'],
            [['name', 'image', 'meta_title', 'local'], 'string', 'max' => 255],
            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
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
            'news_id' => Yii::t('common', 'News ID'),
            'name' => 'Название',
            'short' => 'Анонс',
            'text' => 'Текст',
            'image' => 'Картинка',
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
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }
}
