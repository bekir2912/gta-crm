<?php

namespace api\transformers;

use Yii;

class CityList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'name' => $item->translate->name,
                'geo_lat' => $item->lat? $item->lat: null,
                'geo_lng' => $item->lng? $item->lng: null,
            ];
            $loop++;
        }

        return $data;
    }
}