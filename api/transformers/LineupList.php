<?php

namespace api\transformers;

use Yii;

class LineupList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'name' => $item->translate->name,
            ];
            $loop++;
        }

        return $data;
    }
}