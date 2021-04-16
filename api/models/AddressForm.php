<?php
namespace frontend\models;

use common\models\UserAddress;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class AddressForm extends Model
{
    public $id;
    public $name;
    public $address;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'trim'],
            [['id'], 'integer'],
            [['name', 'address'], 'trim'],
            [['name', 'address'], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['address', 'string'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('frontend', 'Title'),
            'address' => Yii::t('frontend', 'Address'),
        ];
    }

    public function saveAddress()
    {
        if (!$this->validate()) {
            return null;
        }
        $address = ($this->id)? UserAddress::findOne([$this->id, 'user_id' => Yii::$app->user->id]) :new UserAddress();
        $address->user_id = Yii::$app->user->id; //$this->username;
        $address->name = $this->name; //$this->username;
        $address->address = $this->address; //$this->username;
        return $address->save() ? $address : null;
    }
}
