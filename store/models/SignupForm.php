<?php

namespace store\models;

use common\components\SmsService;
use common\models\City;
use common\models\Seller;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $username;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('frontend', 'You are registered already')],

//            ['password', 'required'],
//            ['password', 'string', 'min' => 6],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('frontend', 'Name'),
            'username' => Yii::t('frontend', 'E-mail'),
        ];
    }

    public function isEmail()
    {
        return filter_var($this->username, FILTER_VALIDATE_EMAIL);
    }

    public function isPhone()
    {
        $smsService = new SmsService();
        return $smsService->isUzPhone($smsService->clearPhone($this->username));
    }

    /**
     * Signs user up.
     *
     * @return Seller|null the saved model or null if saving fails
     */
    public function signup($password)
    {
        $smsService = new SmsService();
        if (!$this->validate()) {
            return null;
        }
        if (!$this->isEmail() && !$this->isPhone()) {
            $this->addError('username', 'Incorrect username');
            return null;
        }

        $user = new Seller();

        if ($this->isEmail()) {
            $fuser = User::findByUsername($this->username);
            if (!$fuser) {
                $city = City::find()->where(['status' => 1])->orderBy('`order` ASC')->one();
                $fuser = new User();
                $fuser->username = $this->username; //$this->username;
                $fuser->phone = null;
                $fuser->name = $this->name; //$this->username;
                $fuser->city_id = $city ? $city->id : null;
                $fuser->avatar = null;
                $fuser->birthday = null;
                $fuser->balance = 0;
                $fuser->setPassword($password);
                $fuser->generateAuthKey();
                $fuser->save();
            }

            $user->username = $this->username; //$this->username;
            $user->phone = null;
        } else if ($this->isPhone()) {
            $fuser = User::findByUsername($smsService->clearPhone($this->username));
            if (!$fuser) {
                $city = City::find()->where(['status' => 1])->orderBy('`order` ASC')->one();
                $fuser = new User();
                $fuser->username = $smsService->clearPhone($this->username); //$this->username;
                $fuser->phone = $smsService->clearPhone($this->username);
                $fuser->name = $this->name; //$this->username;
                $fuser->city_id = $city ? $city->id : null;
                $fuser->avatar = null;
                $fuser->birthday = null;
                $fuser->balance = 0;
                $fuser->setPassword($password);
                $fuser->generateAuthKey();
                $fuser->save();
            }

            $user->username = $smsService->clearPhone($this->username); //$this->username;
            $user->phone = $smsService->clearPhone($this->username);
        }

        $user->name = $this->name; //$this->username;
//        $user->city_id = $city? $city->id: null;
//        $user->avatar = null;
//        $user->birthday = null;
        $user->balance = 0;
        $user->setPassword($password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    public function sendEmail($password)
    {

        $smsService = new SmsService();
        if ($this->isPhone()) {
            $this->username = $smsService->clearPhone($this->username);
        }

        /* @var $user Seller */
        $user = Seller::findOne([
            'status' => Seller::STATUS_ACTIVE,
            'username' => $this->username,
        ]);

        if (!$user) {
            return false;
        }

        if ($this->isEmail()) {
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'sellerSignUp-html', 'text' => 'sellerSignUp-text'],
                    ['user' => $user, 'password' => $password]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->username)
                ->setSubject('Registration on ' . Yii::$app->name)
                ->send();
        } else if ($this->isPhone()) {
            return $smsService->send($smsService->clearPhone($this->username), 'Ваш пароль от GTA: ' . $password);
        }

        return false;
    }
}
