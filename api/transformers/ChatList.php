<?php

namespace api\transformers;

use Yii;

class ChatList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            if($item->type == 'shop') {
                $new_chat = \common\models\Chat::find()->where(['user_id' => Yii::$app->user->identity->id, 'type' => 'shop', 'direction' => '2', 'is_read' => 0])->count();
                $im = base64_encode($item->type.':'.$item->shop->id);
                $name = $item->shop->name;
                $ava = $item->shop->logo;
            } else {
                $new_chat = \common\models\Chat::find()->where(['user_id' => $item->shop_id, 'shop_id' => Yii::$app->user->identity->id, 'type' => 'user', 'is_read' => 0])->count();
                $im = base64_encode($item->type.':'.$item->shop_id);
                $user = \common\models\User::findOne($item->shop_id);
                $name = $user->name;
                $ava = $user->avatar? $user->avatar: '/uploads/site/default_shop.png';
            }

            $data[$loop] = [
                'name' => $name,
                'ava' => $ava,
                'new_messages' => $new_chat,
//                'mes' => $item->message,
//                'date' => $item->created_at,
                'im' => $im,
            ];
            $loop++;
        }

        return $data;
    }
}