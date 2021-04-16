<?php
namespace api\models;

use common\components\SmsService;
use common\models\City;
use Yii;
use yii\base\Model;
use common\models\User;

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

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($password)
    {
        $smsService = new SmsService();
        if (!$this->validate()) {
            return null;
        }
        if(!$this->isEmail() && !$this->isPhone()) {
            $this->addError('username', 'Incorrect username');
            return null;
        }

        $city = City::find()->where(['status' => 1])->orderBy('`order` ASC')->one();
        $user = new User();

        if($this->isEmail()) {
            $user->username = $this->username; //$this->username;
            $user->phone = null;
        } else if ($this->isPhone()) {
            $user->username = $smsService->clearPhone($this->username); //$this->username;
            $user->phone = $smsService->clearPhone($this->username);
        }

        $user->name = $this->name; //$this->username;
        $user->city_id = $city? $city->id: null;
        $user->avatar = null;
        $user->birthday = null;
        $user->balance = 10000;
        $user->setPassword($password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function isEmail() {
        return filter_var($this->username, FILTER_VALIDATE_EMAIL);
    }

    public function isPhone() {
        $smsService = new SmsService();
        return $smsService->isUzPhone($smsService->clearPhone($this->username));
    }

    public function sendEmail($password)
    {

        $smsService = new SmsService();
        if ($this->isPhone()) {
            $this->username = $smsService->clearPhone($this->username);
        }

        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'username' => $this->username,
        ]);

        if (!$user) {
            return false;
        }

        if($this->isEmail()) {
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'signUp-html', 'text' => 'signUp-text'],
                    ['user' => $user, 'password' => $password]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->username)
                ->setSubject('Registration on ' . Yii::$app->name)
                ->send();
        } else if ($this->isPhone()) {
            return $smsService->send($smsService->clearPhone($this->username), 'Ваш пароль от GTA: '.$password);
        }

        return false;
    }
}
