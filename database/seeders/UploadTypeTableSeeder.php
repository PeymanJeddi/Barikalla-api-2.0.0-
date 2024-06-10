<?php

namespace Database\Seeders;

use App\Services\KindService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UploadTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KindService::Seeder('نوع اپلود', 'upload_type', 'نام', '', [
            ['key' => 'avatar', 'value_1' => 'آواتار پروفایل'],
            ['key' => 'birth-certificate', 'value_1' => 'شناسنامه' ],
            ['key' => 'national-card', 'value_1' => 'کارت ملی'],
        ]);
    }
}
