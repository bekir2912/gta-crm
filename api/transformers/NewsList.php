<?php

namespace api\transformers;

use Yii;

class NewsList
{
    public static function transform($list, $counts = null)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {

            $data[$loop] = [
                'id' => $item->id,
                'name' => $item->translate->name,
                'short' => $item->translate->short,
                'text' => $item->translate->text,
                'image' => $item->translate->image,
                'addedAt' => (string) date('d.m.Y H:i', $item->created_at),
            ];

            $loop++;
        }

        return $data;
    }
}