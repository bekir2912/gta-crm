<?php

namespace api\transformers;

use Yii;

class BrandsList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'name' => $item->name,
                'logo' => $item->logo,
            ];
            $loop++;
        }

        return $data;
    }
}