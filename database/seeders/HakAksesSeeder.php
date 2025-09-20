<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\HakAkses;

class HakAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HakAkses::insert([
            ['nama_hak_akses' => 'view'],
            ['nama_hak_akses' => 'edit'],
            ['nama_hak_akses' => 'share'],
            ['nama_hak_akses' => 'delete']
        ]);
    }
}
