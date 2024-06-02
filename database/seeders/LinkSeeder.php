<?php

namespace Database\Seeders;

use App\Services\KindService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KindService::Seeder('لینک', 'link', 'تایپ', 'آدرس پیش‌فرض', [
            ['key' => 'link-instagram', 'value_1' => 'instagram', 'value_2' => 'https://instagram.com/'],
            ['key' => 'link-telegram', 'value_1' => 'telegram', 'value_2' => 'https://t.me/'],
            ['key' => 'link-url', 'value_1' => 'url', 'value_2' => ''],
        ]);
    }
}
