<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@sjp.ac.lk',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('123'),//password

        ])->assignRole('Super-Admin');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@sjp.ac.lk',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('123'),//password

        ])->assignRole('Admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@sjp.ac.lk',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('123'),//password

        ])->assignRole('User');
    }
}
