<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'vip',
            'streamer',
            'developer'
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role], [
                'name' => $role,
                'guard_name' => 'api',
            ]);
        }
    }
}
