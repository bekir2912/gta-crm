<?php

namespace api\transformers;

use Yii;

class MessageList
{
    public static function transform($chat, $list)
    {
        $data = ['chat' => [], 'messages' => []];

        $data['chat'] = ChatList::transform([$chat]);

        $loop = 0;
        foreach ($list as $item) {
            if($item->type == 'shop') {
                $class = ($item->direction == 1)? 'message-out': 'message-in';
            } else {
                if ($item->user_id ==  Yii::$app->user->id) {
                    $class = 'message-out';
                } else {
                    $class = 'message-in';
                }
            }
            $ava = ($item->direction == 1)? ($item->user->avatar? $item->user->avatar: '/uploads/site/default_shop.png'): $item->shop->logo;

            $data['messages'][$loop] = [
                'type' => $class,
                'message' => $item->message? $item->message: "",
                'ava' => $ava,
                'hasFile' => $item->hasFile,
                'fileType' => $item->fileType,
                'mime' => $item->mime,
                'file' => $item->file,
                'geo' => $item->geo,
                'created_at' => date('d.m.Y H:i', $item->created_at),
            ];
            $loop++;
        }

        return $data;
    }
}