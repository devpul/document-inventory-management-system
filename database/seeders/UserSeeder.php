<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Users::insert([
            [
                'role_id' => 1,
                'nama' => 'Asep Saepuloh',
                'password' => bcrypt('asep123'),
                'email' => 'asep@gmail.com',
                'no_telepon' => '083875999686',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_id' => 2,
                'nama' => 'Bambang',
                'password' => bcrypt('bambang123'),
                'email' => 'bambang@gmail.com',
                'no_telepon' => '083143053730',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
