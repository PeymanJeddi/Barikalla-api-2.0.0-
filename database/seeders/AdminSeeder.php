<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'iman',
                'last_name' => 'peyvandi pour',
                'username' => '4example',
                'mobile' => '09363778722',
                'is_admin' => 1,
                'password' => bcrypt('Iman1398.'),
            ],
            [
                'first_name' => 'peyman',
                'last_name' => 'jeddi',
                'username' => 'peyman',
                'nickname' => 'Peyman Jeddi',
                'mobile' => '09356984516',
                'is_admin' => 1,
                'password' => bcrypt('RamzGhavi1403'),
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['mobile' => $user['mobile']], [
                ...$user,
            ]);
        }
    }
}
