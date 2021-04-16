<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $order
 * @property integer $status
 *
 * @property StaticPageCategoryTranslation[] $staticPageCategoryTranslations
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'name', 'created_at', 'updated_at'], 'required'],
            [['default', 'created_at', 'updated_at', 'order', 'status'], 'integer'],
            [['url', 'local', 'name'], 'string', 'max' => 255],
            [['local'], 'unique'],
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
            'url' => Yii::t('common', 'Url'),
            'local' => Yii::t('common', 'Local'),
            'name' => Yii::t('common', 'Name'),
            'default' => Yii::t('common', 'Default'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'order' => Yii::t('common', 'Order'),
            'status' => Yii::t('common', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticPageCategoryTranslations()
    {
        return $this->hasMany(StaticPageCategoryTranslation::className(), ['local' => 'local']);
    }

    //Переменная, для хранения текущего объекта языка
    static $current = null;

    //Получение текущего объекта языка
    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

    //Установка текущего объекта языка и локаль пользователя
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->local;
    }

    //Получения объекта языка по умолчанию
    static function getDefaultLang()
    {
        return Language::find()->where('`default` = :default', [':default' => 1])->one();
    }

    //Получения объекта языка по буквенному идентификатору
    static function getLangByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $language = Language::find()->where('`url` = :url AND `status` = :status', [':url' => $url, ':status' => 1])->one();
            if ( $language === null ) {
                return null;
            }else{
                return $language;
            }
        }
    }
}
