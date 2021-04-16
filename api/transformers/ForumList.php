<?php

namespace api\transformers;

use Yii;

class ForumList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'user_name' => $item->user->name,
                'user_photo' => $item->user->avatar? $item->user->avatar: '/uploads/site/default_shop.png',
                'question' => $item->question,
                'file' => $item->file,
                'answersCount' => $item->getAnswersCount(),
                'created_at' => date('d.m.Y H:i', $item->created_at),
            ];
            $loop++;
        }

        return $data;
    }
}