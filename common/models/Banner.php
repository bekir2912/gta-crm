<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property integer $order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BannerTranslation[] $BannerTranslation
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expires_in'], 'required'],
            [['order', 'status', 'clicks', 'type'], 'integer'],
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
            'expires_in' => 'Показывать до',
            'type' => 'Тип',
            'clicks' => 'Клики',
            'url' => 'Ссылка',
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
    public function getBannerTranslation()
    {
        return $this->hasMany(BannerTranslation::className(), ['banner_id' => 'id']);
    }

    public function getTranslate() {
        return ($this->hasOne(BannerTranslation::className(), ['banner_id' => 'id'])->where(['local' => Language::getCurrent()->local])->all())? $this->hasOne(BannerTranslation::className(), ['banner_id' => 'id'])->where(['local' => Language::getCurrent()->local]): $this->hasOne(BannerTranslation::className(), ['banner_id' => 'id'])->where(['local' => Language::getDefaultLang()->local]);
    }
}
