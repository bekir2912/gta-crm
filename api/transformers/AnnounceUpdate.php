<?php

namespace api\transformers;

use common\models\Product;
use common\models\ProductTranslation;
use common\models\Shop;
use common\models\User;
use Yii;

class AnnounceUpdate
{
    public static function transform($item)
    {
        if ($item instanceof Product) {
            $info = ProductTranslation::findOne((['product_id' => $item->id, 'local' => 'ru-RU']));
            $info->scenario = 'create';
            $info_uz = ProductTranslation::findOne((['product_id' => $item->id, 'local' => 'uz-UZ']));
            if (!$info_uz) $info_uz = new ProductTranslation();
            $info_en = ProductTranslation::findOne((['product_id' => $item->id, 'local' => 'en-EN']));
            if (!$info_en) $info_en = new ProductTranslation();
            $info_oz = ProductTranslation::findOne((['product_id' => $item->id, 'local' => 'oz-OZ']));
            if (!$info_oz) $info_oz = new ProductTranslation();

            $data = [
                'id' => $item->id,
                'category_id' => $item->category_id,
                'brand_id' => $item->brand_id,
                'lineup_id' => $item->lineup_id,
                'price' => (int)($item->currency == 'uzs' ? $item->price : $item->price_usd),

                'status' => $item->status,
                'created_at' => (string)date('d.m.Y H:i', $item->created_at),
                'km' => (int)$item->km,
                'currency' => $item->currency,
                'type' => $item->type,
                'colored_offer' => $item->colored_offer > time() ? true : false,
                'special_offer' => $item->special_offer > time() ? true : false,
                'colored_offer_date' => $item->colored_offer > time() ? (string)date('d.m.Y H:i', $item->colored_offer) : null,
                'special_offer_date' => $item->special_offer > time() ? (string)date('d.m.Y H:i', $item->special_offer) : null,

                'mainImage' => $item->mainImage->image,
                'otherImages' => null,

                'options' => [
                ],
                'custom_options' => [
                    'groups' => [],
                    'values' => [],],
                'translations' => [
                    'name' => [
                        'ru' => $info->name,
                        'en' => $info_en->name,
                        'uz' => $info_uz->name,
                        'oz' => $info_oz->name,
                    ],
                    'description' => [
                        'ru' => $info->description,
                        'en' => $info_en->description,
                        'uz' => $info_uz->description,
                        'oz' => $info_oz->description,
                    ],
                    'warranty' => [
                        'ru' => $info->warranty,
                        'en' => $info_en->warranty,
                        'uz' => $info_uz->warranty,
                        'oz' => $info_oz->warranty,
                    ],
                    'delivery' => [
                        'ru' => $info->delivery,
                        'en' => $info_en->delivery,
                        'uz' => $info_uz->delivery,
                        'oz' => $info_oz->delivery,
                    ],
                ]
            ];

            foreach ($item->otherImages as $otherImage) {
                $data['otherImages'][] = [
                    'id' => $otherImage->id,
                    'img' => $otherImage->image,
                ];
            }

            if (!empty($item->activeOptions)) {
                foreach ($item->activeOptions as $checked_opt) {
                    $data['options'][] = $checked_opt->option_id;
                }
            }

            $custom_options = ($item->custom_options) ? json_decode($item->custom_options, true) : [];
            if (!empty($custom_options)) {
                foreach ($custom_options as $group => $value) {
                    $data['custom_options']['groups'][] = $group;
                    $data['custom_options']['values'][] = $value;
                }
            }

            $data['def_price'] = $data->price == 0 ? true : false;
            return $data;
        }

        return [];
    }
}