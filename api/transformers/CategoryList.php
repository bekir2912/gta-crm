<?php

namespace api\transformers;

use Yii;

class CategoryList
{
    public static function transform($list)
    {
        $data = [];

        $loop = 0;
        foreach ($list as $item) {
            $data[$loop] = [
                'id' => $item->id,
                'name' => $item->translate->name,
                'parent_id' => $item->parent_id? $item->parent_id: null,
                'isService' => $item->on_main == 1? true: false,
                'isSpecial' => $item->spec == 1? true: false,
                'icon' => $item->icon,
                'types' => null,
                'subCats' => null,
            ];

            if ($item->on_main == 0 && $item->spec == 0) {
                $data[$loop]['types'] = [
                    ['slug' => 'sell', 'name' => Yii::t('frontend', 'Sell')],
                    ['slug' => 'buy', 'name' => Yii::t('frontend', 'Buy')],
                    ['slug' => 'arenda', 'name' => Yii::t('frontend', 'Arenda')],
                ];
            }

            foreach ($item->activeCategories as $activeCategory) {
                $data[$loop]['subCats'][] = [
                    'id' => $activeCategory->id,
                    'name' => $activeCategory->translate->name,
                    'icon' => $activeCategory->icon,
                    'hasChild' => ($activeCategory->activeCategories)? true: false,
                ];
            }

            $loop++;
        }

        return $data;
    }
}