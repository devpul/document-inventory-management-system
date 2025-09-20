<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Dokumen;
use App\Models\LogDokumen;


class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dokumen::insert([
        //     [
        //         'owner_id' => 3, //M Ibnu
        //         'kategori_id' => 1, //SOP
        //         'nomor_dokumen' => 'SOP/2025/001',
        //         'nama_dokumen' => 'Market Analyst Report',
        //         'keyword' => 'keyword 1, keyword 2, SOP, Report',
        //         'deskripsi' => 'Deskripsi untuk Market Analyst Report',
        //         'tanggal_terbit' => '2020-05-20',
        //         'status' => 'draf',
        //         'file_attachment' => 'market_analyst_report.xlsx'
        //     ],
            
        //     [
        //         'owner_id' => 3, //M Ibnu
        //         'kategori_id' => 2, //NON-SOP
        //         'nomor_dokumen' => 'LPR/2024/001',
        //         'nama_dokumen' => 'Laporan Keuangan',
        //         'keyword' => 'keyword 1, keyword 2, SOP, Report',
        //         'deskripsi' => 'Deskripsi untuk Laporan Keuangan',
        //         'tanggal_terbit' => '2023-12-29',
        //         'status' => 'draf',
        //         'file_attachment' => 'laporan_keuangan.pdf'
        //     ]

            
        // ]);

        LogDokumen::insert([
            [
                'dokumen_id' => 1,
                'tanggal_dibagikan' => null,
                'tanggal_dibuat' => now(),
                'tanggal_diubah' => null,
                'tanggal_dihapus' => null,
            ],

            [
                'dokumen_id' => 2,
                'tanggal_dibagikan' => null,
                'tanggal_dibuat' => now(),
                'tanggal_diubah' => null,
                'tanggal_dihapus' => null,
            ],
        ]);
    }
}
