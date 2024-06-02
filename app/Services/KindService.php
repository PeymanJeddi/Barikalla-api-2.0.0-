<?php

namespace App\Services;
use App\Models\Kind;
use App\Models\KindCategory;

class KindService
{

    public static function Seeder($title, $key, $labelValue1, $labelValue2, $options, $parent_key = null , $labelKey = 'کد یکتا')
    {
        $parent_id = null;
        if ($parent_key != null) {
            $category = KindCategory::where('key', $parent_key)->first();
            $parent_id = $category->id;
        }
        $kindCategory = KindCategory::updateOrCreate(
            ['key' => $key],
            [
                'title' => $title,
                'key' => $key,
                'label_key' => $labelKey,
                'label_value_1' => $labelValue1,
                'label_value_2' => $labelValue2,
                'parent_id' => $parent_id,
            ]
        );

        if (!empty($options)) {
            foreach($options as $option) {
                $parent_id = null;
                if (isset($option['parent_key'])) {
                    $parent_id = Kind::where('key', $option['parent_key'])->first()->id;
                }
                $kindCategory->kinds()->updateOrCreate(['key' => $option['key']], [
                    'key' => $option['key'],
                    'value_1' => $option['value_1'],
                    'value_2' => $option['value_2'] ?? '',
                    'parent_id' => $parent_id,
                ]);
            }
        }
    }
}