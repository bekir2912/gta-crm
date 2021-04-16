<?php

namespace api\transformers;

use Yii;

class WikiLineupList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'brand_id' => $item->brand_id,
                'name' => $item->translate->name,
                'description' => $item->translate->description,
                'image' => $item->logo,
                'performances' => null,
            ];

            foreach ($item->activeOptions as $option) {
//                if ($option->option->group->main == 0) continue;

                if(!isset($data[$loop]['performances'][$option->option->group->id]['group'])) {
                    $data[$loop]['performances'][$option->option->group->id]['group'] = [
//                    'group' => [
                        'id' => $option->option->group->id,
                        'name' => $option->option->group->translate->name,
                        'options' => null
//                    ],
                    ];
                }
                $data[$loop]['performances'][$option->option->group->id]['group']['options'][] = [
                    'id' => $option->option->id,
                    'name' => $option->option->translate->name,
                ];
            }

            if (is_array($data[$loop]['performances'])) {
                $data[$loop]['performances'] = array_values($data[$loop]['performances']);
            }

            $loop++;
        }

        return $data;
    }
}