<?php

use common\models\Seller;
use common\models\User;
use yii\db\Migration;

class m180306_012414_sellers_sets_as_users extends Migration
{
    public function safeUp()
    {
        $sellers = Seller::find()->asArray()->all();

        if(!empty($sellers)) {
            foreach ($sellers as $seller) {
                if(User::findByUsername($seller['username'])) continue;
                if(User::findOne(['email' => $seller['username']])) continue;
                if(User::findOne(['phone' => $seller['phone']])) continue;
                $user = new User();
                $user->username = $seller['username'];
                $user->name = $seller['name'];
                $user->phone = $seller['phone'];
                $user->auth_key = $seller['auth_key'];
                $user->password_hash = $seller['password_hash'];
                $user->password_reset_token = $seller['password_reset_token'];
                $user->email = $seller['email'];
                $user->status = $seller['status'];
                $user->created_at = $seller['created_at'];
                $user->updated_at = $seller['updated_at'];
                $user->save();
            }
        }
    }

    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180306_012414_sellers_sets_as_users cannot be reverted.\n";

        return false;
    }
    */
}
