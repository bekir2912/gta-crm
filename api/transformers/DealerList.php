<?php

namespace api\transformers;

use common\models\Shop;
use Yii;

class DealerList
{
    public static function transform($list, $counts = null)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $cities = json_decode($item->cities);
            $city_name = '';
            if (!empty($cities)) {
                foreach ($cities as $city) {
                    $db_city = \common\models\City::findOne(['id' => $city, 'status' => 1]);
                    if($db_city) {
                        $city_name .= $db_city->translate->name.', ';
                    }
                }
                $city_name = mb_substr($city_name, 0, -2);
            }

            $data[$loop] = [
                'id' => $item->id,
                'message_im' => base64_encode('shop:'.$item->id),
                'hasPhone' => false,
                'name' => $item->name,
                'logo' => $item->logo,
                'description' => $item->info->description,
                'city' => $city_name,
                'address' => $item->info->address,
                'schedule' => $item->info->getScheduleFormApi(),
                'announce_count' => null,
                'viewed' => $item->view,
                'rating' => $item->rating,
                'reviews_count' => $item->getReviewsCount(),

                'geo_lat' => $item->info->lat? $item->info->lat: null,
                'geo_lng' => $item->info->lng? $item->info->lng: null,
            ];

            $test = array_filter(explode('; ', $item->info->phone));
            if (!empty($test)) {
                $data[$loop]['hasPhone'] = true;
            }

            if ($counts) {
                $data[$loop]['announce_count'] = (isset($counts[$item->id])? $counts[$item->id]: 0).Yii::t('frontend', 'unit');
            }

            $loop++;
        }

        return $data;
    }
}