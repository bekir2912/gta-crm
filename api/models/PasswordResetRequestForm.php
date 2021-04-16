<?php
namespace api\models;

use common\components\SmsService;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'E-mail'),
        ];
    }

    public function isEmail() {
        return filter_var($this->username, FILTER_VALIDATE_EMAIL);
    }

    public function isPhone() {
        $smsService = new SmsService();
        return $smsService->isUzPhone($smsService->clearPhone($this->username));
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {

        $smsService = new SmsService();
        if($this->isPhone()) {
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
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
                if (!$user->save()) {
                    return false;
                }
            }

            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                    ['user' => $user]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->username)
                ->setSubject('Password reset for ' . Yii::$app->name)
                ->send();
        } else if ($this->isPhone()) {
            $password = mt_rand(100000, 999999);

            $user->setPassword($password);
            $user->generateAuthKey();
            $user->save();

            return $smsService->send($smsService->clearPhone($this->username), 'Ваш новый пароль от GTA: '.$password);
        }

        return false;
    }
}
