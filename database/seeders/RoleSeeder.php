<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'short_name' => 'admin'
            ],
            [
                'name' => 'User',
                'short_name' => 'user'
            ],
            [
                'name' => 'Manager',
                'short_name' => 'manager'
            ]
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['short_name' => $role['short_name']],
                $role
            );
        }
    }
}
