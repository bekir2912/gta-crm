<?php
namespace api\models;

use common\components\SimpleImage;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class ProfileForm extends Model
{
    public $name;
    public $phone;
    public $push;
    public $password;
    public $passwordconfirm;
    public $city_id;
    public $avatar;
    public $birthday;
    public $ucard;
    public $img;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            [['name', 'city_id'], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['avatar', 'file'],
            ['birthday', 'string', 'min' => 2, 'max' => 255],
            ['city_id', 'integer'],
            ['ucard', 'integer'],
            ['phone', 'string'],
            ['push', 'safe'],
//            ['phone', 'match', 'pattern' => '/^\\d{12}$/i'],

//            ['email', 'trim'],
//            ['email', 'required'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['phone', 'unique', 'targetClass' => '\common\models\User', 'when' => function($model) {return $model->phone != Yii::$app->getUser()->identity->phone;}],

//            ['password', 'required'],
            [['password'], 'string', 'min' => 6],
            ['passwordconfirm', 'compare', 'compareAttribute'=>'password'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('frontend', 'Name'),
            'phone' => Yii::t('frontend', 'Phone'),
            'password' => Yii::t('frontend', 'New password'),
            'passwordconfirm' => Yii::t('frontend', 'New password confirm'),
            'ucard' => Yii::t('frontend', 'My ID Ucard'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateProfile()
    {
        if (!$this->validate()) {
            return null;
        }

        $image = $this->uploadProfilePicture();


        $user = User::findOne(Yii::$app->user->id);
        $root = realpath(dirname(__FILE__).'/../../');

        $oldFile = $user->avatar;
        if($image !== false) {
            if($image->saveAs($root.'/uploads/users/'.$this->avatar)) {
                $resizer = new SimpleImage();
                $resizer->load($root.'/uploads/users/'.$this->avatar);
                $resizer->resize(200, 200);
                $image_name = uniqid().'.'.$image->extension;
                $resizer->save($root.'/uploads/users/'.$image_name);
                if(is_file($root.'/uploads/users/'.$this->avatar) && file_exists($root.'/uploads/users/'.$this->avatar)) {
                    unlink($root.'/uploads/users/'.$this->avatar);
                }
                $user->avatar = '/uploads/users/'.$image_name; //$this->username;
                if(!empty($oldFile) && file_exists($root.$oldFile)) {
                    unlink($root.$oldFile);
                }
            }
        }

        $user->name = $this->name; //$this->username;
        $user->ucard = $this->ucard; //$this->username;
        $user->city_id = $this->city_id; //$this->username;
        $user->birthday = $this->birthday; //$this->username;
        $user->push = $this->push; //$this->username;
//        $user->phone = $this->phone? $this->phone: null; //$this->username;
        if($this->password) {
            $user->setPassword($this->password);
        }
        return $user->save() ? $user : null;
    }

    /**
     * Process upload of profile picture
     *
     * @return mixed the uploaded profile picture instance
     */
    public function uploadProfilePicture() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = $this->img;

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        //$this->filename = $image->name;
        $imageName = (explode(".", $image->name));
        $ext = end($imageName);

        // generate a unique file name
        $this->avatar = uniqid().".{$ext}";

        // the uploaded profile picture instance
        return $image;
    }
}
