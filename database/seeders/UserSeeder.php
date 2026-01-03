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
        User::factory()->count(20)->create();

        User::create([
            'name' => 'Admin User',
            'national_code' => '1234567890',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
