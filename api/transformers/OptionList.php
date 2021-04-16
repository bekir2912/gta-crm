<?php

namespace api\transformers;

use Yii;

class OptionList
{
    public static function transform($list, $category)
    {
        $data = [];

        $loop = 0;
        foreach ($list['group'] as $group_id => $group) {
            if ($group->category_id != $category) {
                continue;
            }
            if (empty($list['values'][$group_id])) {
                continue;
            } if (count($list['values'][$group_id]) <= 1) {
                continue;
            }
            $data[$loop] = [
                'group' => $group->translate->name,
                'group_id' => $group->id,
                'type' => ($group->type == 1) ? 'checkbox' : 'select',
                'main' => ($group->main == 1) ? true : false,
                'options' => null,
            ];


            foreach ($list['values'][$group_id] as $value) {
                $data[$loop]['options'][] = [
                    'id' => $value->id,
                    'name' => $value->translate->name,
                ];
            }

            $loop++;
        }

        return $data;
    }
}