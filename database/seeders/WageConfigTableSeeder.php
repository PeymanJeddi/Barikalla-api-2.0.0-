<?php

namespace Database\Seeders;

use App\Services\KindService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WageConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KindService::Seeder('تنظیمات کارمزد', 'wage_config', 'نام تنظیم', 'مقدار', [
            ['key' => 'default_wage', 'value_1' => 'کارمزد پیش فرض', 'value_2' => '2.5'],
            ['key' => 'none_wage', 'value_1' => 'بدون کارمزد', 'value_2' => '0'],
        ]);
    }
}
