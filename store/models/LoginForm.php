<?php
namespace store\models;

use common\components\SmsService;
use common\models\Seller;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
//            [['username'], 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'E-mail'),
            'password' => Yii::t('frontend', 'Password'),
            'rememberMe' => Yii::t('frontend', 'Remember me'),
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный Email или пароль');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Seller|null
     */
    protected function getUser()
    {
        $smsService = new SmsService();
        if($this->isPhone()) {
            $this->username = $smsService->clearPhone($this->username);
        }
        if ($this->_user === null) {
            $this->_user = Seller::findByUsername($this->username);
        }

        return $this->_user;
    }
    protected function isPhone() {
        $smsService = new SmsService();
        return $smsService->isUzPhone($smsService->clearPhone($this->username));
    }
}
