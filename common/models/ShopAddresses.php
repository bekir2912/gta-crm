<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "shop_addresses".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property string $description
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $local
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Language $local0
 * @property Shop $shop
 */
class ShopAddresses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['shop_id', 'phone', 'email', 'local', 'created_at', 'updated_at'], 'required'],
//            [['email'], 'required', 'on' => 'create'],
            [['description', 'address', 'phone', 'email'], 'trim', 'on' => 'create'],
            [['shop_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'address'], 'string', 'min' => 2],
            ['email', 'email'],
            ['schedule', 'safe'],
            [['phone', 'email', 'local', 'lat', 'lng'], 'string', 'max' => 255],
            [['local'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['local' => 'local']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
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
            'shop_id' => Yii::t('common', 'Shop ID'),
            'description' => 'Описание',
            'schedule' => 'Режим работы',
            'address' => 'Адрес',
            'phone' => 'Телефоны',
            'email' => 'E-mail',
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
     * @return string
     */
    public function getScheduleForm()
    {
        $lang = Language::getCurrent()->local;

        $days = [
            'ru-RU' => [
                0 => '24 часа',
                1 => 'Понедельник',
                2 => 'Вторник',
                3 => 'Среда',
                4 => 'Четверг',
                5 => 'Пятница',
                6 => 'Суббота',
                7 => 'Воскресенье'
            ],
            'en-EN' => [
                0 => '24 hours',
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                7 => 'Sunday'],
            'uz-UZ' => [
                0 => '24 soat',
                1 => 'Dushanba',
                2 => 'Seshanba',
                3 => 'Chorshanba',
                4 => 'Payshanba',
                5 => 'Juma',
                6 => 'Shanba',
                7 => 'Yakshanba'],
        ];

        $schedule = json_decode($this->schedule, 1);

        $result = '';
        if (is_array($schedule['days'])) {
            foreach ($schedule['days'] as $i => $day) {
                if ($day == 1) $result .= '<b>' . $days[$lang][$i] . ':</b> ' . (($schedule['alltime'][$i] == 1) ? $days[$lang][0] : $schedule['time'][$i][1] . ' - ' . $schedule['time'][$i][2]) . '<br>';
            }
        }

        return $result;
    }

    public function getScheduleFormApi()
    {
        $lang = Language::getCurrent()->local;

        $days = [
            'ru-RU' => [
                0 => '24 часа',
                1 => 'Понедельник',
                2 => 'Вторник',
                3 => 'Среда',
                4 => 'Четверг',
                5 => 'Пятница',
                6 => 'Суббота',
                7 => 'Воскресенье'
            ],
            'en-EN' => [
                0 => '24 hours',
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                7 => 'Sunday'],
            'uz-UZ' => [
                0 => '24 соат',
                1 => 'Душанба',
                2 => 'Сешанба',
                3 => 'Чоршанба',
                4 => 'Пайшанба',
                5 => 'Жума',
                6 => 'Шанба',
                7 => 'Якшанба'],
            'oz-OZ' => [
                0 => '24 soat',
                1 => 'Dushanba',
                2 => 'Seshanba',
                3 => 'Chorshanba',
                4 => 'Payshanba',
                5 => 'Juma',
                6 => 'Shanba',
                7 => 'Yakshanba'],
        ];

        $schedule = json_decode($this->schedule, 1);

        $result = [];
        if (is_array($schedule['days'])) {
            foreach ($schedule['days'] as $i => $day) {
                if ($day == 1) {
                    $result[] =
                        [
                            'day' => $days[$lang][$i],
                            'time' => (($schedule['alltime'][$i] == 1) ? $days[$lang][0] : $schedule['time'][$i][1] . ' - ' . $schedule['time'][$i][2]),
                        ];
                }
            }
        }

        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }
}
