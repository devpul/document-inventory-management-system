<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\KategoriDokumen;

class KategoriDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriDokumen::insert([
            ['nama_kategori' => 'SOP', 'deskripsi' => 'Standar Operasional'],
            ['nama_kategori' => 'non-SOP', 'deskripsi' => 'Standar Operasional']
        ]);
    }
}
