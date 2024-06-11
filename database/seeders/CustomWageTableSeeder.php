<?php

namespace Database\Seeders;

use App\Services\KindService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomWageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KindService::Seeder('کارمزد سفارشی', 'custom_wage', 'نام کاربری', 'مقدار', [
            ['key' => '4example-custom-wage', 'value_1' => '4example', 'value_2' => '5'],
        ]);
    }
}
