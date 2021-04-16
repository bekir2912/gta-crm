<?php

namespace api\transformers;

use common\models\Shop;
use common\models\User;
use Yii;

class AnnounceList
{
    public static function transform($list, $currency = null)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            if(!$currency) {
                $currency = $item->currency;
            }
            $data[$loop] = [
                'id' => $item->id,
                'name' => $item->translate->name,
                'description' => $item->translate->description,
                'warranty' => null,
                'delivery' => null,
                'mileage' => ($item->km > 0)? number_format($item->km, 0, '', ' ').' '.Yii::t('frontend', 'km'): null,
                'mainImage' => $item->mainImage->image,
                'otherImages' => null,
                'price' => (string) $item->getApiPrice($currency),
                'addedAt' => (string) date('d.m.Y H:i', $item->created_at),
                'city' => null,
                'colored_offer' => $item->colored_offer > time()? true: false,
                'special_offer' => $item->special_offer > time()? true: false,
                'colored_offer_date' => $item->colored_offer > time()? (string) date('d.m.Y H:i', $item->colored_offer): null,
                'special_offer_date' => $item->special_offer > time()? (string) date('d.m.Y H:i', $item->special_offer): null,
                'viewed' => $item->view,
                'phone_viewed' => $item->phone_views,
                'status' => $item->status,
                'owner' => [
                    'id' => $item->user_id? $item->user_id: $item->shop_id,
                    'type' => $item->user_id? 'user': 'dealer',
                    'message_im' => null,
                    'name' => (string) $item->user_id? $item->user->name: $item->shop->name,
                    'hasPhone' => false,
                ],
                'mainOptions' => null,
                'otherOptions' => null,
            ];

            if ($item->shop_id) {
                $shop = Shop::findOne(['id' => $item->shop_id]);
                $data[$loop]['owner']['message_im'] = base64_encode('shop:'.$item->shop_id);
                if (empty($shop)) {
                    $data[$loop]['owner']['hasPhone'] = false;
                }
                $shop->info->phone = explode('; ', $shop->info->phone);
                if (!empty($shop->info->phone)) {
                    $data[$loop]['owner']['hasPhone'] = true;
                }
            } elseif ($item->user_id) {
                $user = User::findOne(['id' => $item->user_id]);
                $data[$loop]['owner']['message_im'] = base64_encode('user:'.$item->user_id);
                if (empty($user)) {
                    $data[$loop]['owner']['hasPhone'] = false;
                }
                if ($user->phone != '') {
                    $data[$loop]['owner']['hasPhone'] = true;
                }
            }

            foreach ($item->otherImages as $otherImage) {
                $data[$loop]['otherImages'][] = $otherImage->image;
            }

            if($item->user_id) {
                $data[$loop]['city'] = $item->user->city->translate->name;
            } else {
                $cities = json_decode($item->shop->cities);
                if (!empty($cities)) {
                    foreach ($cities as $city) {
                        $db_city = \common\models\City::findOne(['id' => $city, 'status' => 1]);
                        if($db_city) {
                            $data[$loop]['city'] .= $db_city->translate->name.', ';
                        }
                    }
                    $data[$loop]['city'] = mb_substr($data[$loop]['city'], 0, -2);
                }
            }

            foreach ($item->activeOptions as $option) {
                if ($option->option->group->main == 0) continue;

                if(!isset($data[$loop]['mainOptions'][$option->option->group->id]['group'])) {
                    $data[$loop]['mainOptions'][$option->option->group->id]['group'] = [
//                    'group' => [
                        'id' => $option->option->group->id,
                        'name' => $option->option->group->translate->name,
                        'options' => null
//                    ],
                    ];
                }
                $data[$loop]['mainOptions'][$option->option->group->id]['group']['options'][] = [
                    'id' => $option->option->id,
                    'name' => $option->option->translate->name,
                ];
            }

            if (is_array($data[$loop]['mainOptions'])) {
                $data[$loop]['mainOptions'] = array_values($data[$loop]['mainOptions']);
            }

            foreach ($item->activeOptions as $option) {
                if ($option->option->group->main != 0) continue;
                if(!isset($data[$loop]['otherOptions'][$option->option->group->id]['group'])) {
                    $data[$loop]['otherOptions'][$option->option->group->id]['group'] = [
//                    'group' => [
                        'id' => $option->option->group->id,
                        'name' => $option->option->group->translate->name,
                        'options' => null
//                    ],
                    ];
                }
                $data[$loop]['otherOptions'][$option->option->group->id]['group']['options'][] = [
                    'id' => $option->option->id,
                    'name' => $option->option->translate->name,
                ];
            }

            if (is_array($data[$loop]['otherOptions'])) {
                $data[$loop]['otherOptions'] = array_values($data[$loop]['otherOptions']);
            }

            if ($item->category->spec == 1) {
                $data[$loop]['warranty'] = $item->translate->warranty;
                $data[$loop]['delivery'] = $item->translate->delivery;
            }

            $loop++;
        }

        return $data;
    }
}