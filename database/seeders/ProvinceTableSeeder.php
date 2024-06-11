<?php

namespace Database\Seeders;

use App\Services\KindService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KindService::Seeder('استان', 'province', 'نام استان', '', [
            ['key' => 'province-azarbayejan-sharghi', 'value_1' => 'آذربایجان شرقی'],
            ['key' => 'province-azarbayejan-gharbi', 'value_1' => 'آذربایجان غربی'],
            ['key' => 'province-ardebil', 'value_1' => 'اردبیل'],
            ['key' => 'province-esfhan', 'value_1' => 'اصفهان'],
            ['key' => 'province-alborz', 'value_1' => 'البرز'],
            ['key' => 'province-illam', 'value_1' => 'ایلام'],
            ['key' => 'province-booshehr', 'value_1' => 'بوشهر'],
            ['key' => 'province-tehran', 'value_1' => 'تهران'],
            ['key' => 'province-charmahal-bakhtiary', 'value_1' => 'چهارمحال و بختیاری'],
            ['key' => 'province-khorasan-jonoobi', 'value_1' => 'خراسان جنوبی'],
            ['key' => 'province-khorasan-razavi', 'value_1' => 'خراسان رضوی'],
            ['key' => 'province-khorasan-shomali', 'value_1' => 'خراسان شمالی'],
            ['key' => 'province-khoozestan', 'value_1' => 'خوزستان'],
            ['key' => 'province-zanjan', 'value_1' => 'زنجان'],
            ['key' => 'province-semnan', 'value_1' => 'سمنان'],
            ['key' => 'province-systan-baloochestan', 'value_1' => 'سیستان و بلوچستان'],
            ['key' => 'province-fars', 'value_1' => 'فارس'],
            ['key' => 'province-qazvin', 'value_1' => 'قزوین'],
            ['key' => 'province-qom', 'value_1' => 'قم'],
            ['key' => 'province-kordestan', 'value_1' => 'کردستان'],
            ['key' => 'province-kerman', 'value_1' => 'کرمان'],
            ['key' => 'province-kermanshah', 'value_1' => 'کرمانشاه'],
            ['key' => 'province-kohgiloovie-boierahmad', 'value_1' => 'کهگیلویه و بویراحمد'],
            ['key' => 'province-gholestan', 'value_1' => 'گلستان'],
            ['key' => 'province-gilan', 'value_1' => 'گیلان'],
            ['key' => 'province-lorestan', 'value_1' => 'لرستان'],
            ['key' => 'province-mazandaran', 'value_1' => 'مازندران'],
            ['key' => 'province-markazi', 'value_1' => 'مرکزی'],
            ['key' => 'province-hamedan', 'value_1' => 'همدان'],
            ['key' => 'province-hormozgan', 'value_1' => 'هرمزگان'],
            ['key' => 'province-yazd', 'value_1' => 'یزد'],
        ]);
    }
}
