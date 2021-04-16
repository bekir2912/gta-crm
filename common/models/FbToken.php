<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 *
 */
class FbToken extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fb_token_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token'], 'required'],
        ];
    }
}
