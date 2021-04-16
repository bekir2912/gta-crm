<?php

namespace api\transformers;

use Yii;
use yii\helpers\Url;

class BannerList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'name' => $item->translate->name,
                'url' => Url::to(['site/away', 'url' => $item->translate->url]),
                'image' => $item->translate->image,
            ];
            $loop++;
        }

        return $data;
    }
}