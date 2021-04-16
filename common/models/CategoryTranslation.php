<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "category_translations".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keys
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $category
 * @property Language $local0
 */
class CategoryTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required' ,'on' => 'create'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'meta_description', 'meta_keys'], 'string'],
            [['name', 'image', 'meta_title', 'local'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'category_id' => Yii::t('common', 'Category ID'),
            'name' => 'Название',
            'image' => 'Картинка',
            'description' => 'Описание',
            'meta_title' => 'SEO Название',
            'meta_description' => 'SEO Описание',
            'meta_keys' => 'SEO Ключи',
            'local' => Yii::t('common', 'Local'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function afterFind()
    {
        if($this->local == 'uz-UZ') {
            $ru = CategoryTranslation::findOne(['category_id' => $this->category_id, 'local' => 'ru-RU']);
            $this->image = (!empty($ru))? $ru->image : $this->image;
        }
        parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocal()
    {
        return $this->hasOne(Language::className(), ['local' => 'local']);
    }
}
