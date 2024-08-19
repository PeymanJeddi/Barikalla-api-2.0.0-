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
        KindService::Seeder('نوع اپلود', 'upload_type', 'نام', 'دسترسی', [
            ['key' => 'avatar', 'value_1' => 'آواتار پروفایل', 'value_2' => 'public'],
            ['key' => 'birth-certificate', 'value_1' => 'شناسنامه', 'value_2' => 'private'],
            ['key' => 'national-card', 'value_1' => 'کارت ملی', 'value_2' => 'private'],
        ]);
    }
}
