<?php

namespace Database\Seeders;

use App\Services\KindService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KindService::Seeder('عنوان شغلی', 'job', 'عنوان', '', [
            ['key' => 'job-streamer', 'value_1' => 'استریمر'],
        ]);
    }
}
