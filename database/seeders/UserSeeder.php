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
        $super_admin = User::create([
            'first_name' => 'Nour',
            'last_name' => 'Eldein',
            'email' => 'nour.eldein.dev@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $super_admin->assignRole('super_admin');
    }
}
