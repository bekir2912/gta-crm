<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "banner_translations".
 *
 * @property integer $id
 * @property integer $banner_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Banner $banner
 * @property Language $local0
 */
class BannerTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'image', 'url','description', 'local'], 'string', 'max' => 255],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['banner_id' => 'id']],
            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
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
            'banner_id' => Yii::t('common', 'Banner ID'),
            'name' => 'Название',
            'image' => 'Картинка',
            'description' => 'Описание',
            'local' => Yii::t('common', 'Local'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::className(), ['id' => 'banner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocal0()
    {
        return $this->hasOne(Language::className(), ['local' => 'local']);
    }
}
