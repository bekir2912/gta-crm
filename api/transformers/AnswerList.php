<?php

namespace api\transformers;

use Yii;

class AnswerList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'question_id' => $item->question_id,
                'answer' => $item->answer,
                'file' => $item->file,
                'created_at' => (string) date('d.m.Y H:i', $item->created_at),
            ];
            $loop++;
        }

        return $data;
    }
}