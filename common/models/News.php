<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $url
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsTranslation[] $NewsTranslation
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['url', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'url' => 'Ссылка',
            'status' => 'Статус',
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
    public function getNewsTranslation()
    {
        return $this->hasMany(NewsTranslation::className(), ['news_id' => 'id']);
    }


    public function getTranslate() {
        return
            ($this->hasOne(NewsTranslation::className(), ['news_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())?
                $this->hasOne(NewsTranslation::className(), ['news_id' => 'id'])->where(['local' => Language::getCurrent()->local]):
                $this->hasOne(NewsTranslation::className(), ['news_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
