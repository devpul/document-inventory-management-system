<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DokumenHakAkses;

class DokumenHakAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DokumenHakAkses::insert([
            ['dokumen_id' => 1, 'hak_akses_id' => 1],
            ['dokumen_id' => 1, 'hak_akses_id' => 2],
            ['dokumen_id' => 1, 'hak_akses_id' => 3],

            ['dokumen_id' => 2, 'hak_akses_id' => 1],
            ['dokumen_id' => 2, 'hak_akses_id' => 3],
        ]);
    }
}
