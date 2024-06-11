<?php

namespace Database\Seeders;

use App\Services\KindService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KindService::Seeder('تنظیمات درگاه', 'payment_config', 'نام تنظیم', 'مقدار', [
            ['key' => 'tax', 'value_1' => 'مالیات', 'value_2' => '10'],
            ['key' => 'vip_package_price', 'value_1' => 'قیمت اشتراک', 'value_2' => '1000'],
        ]);
    }
}
