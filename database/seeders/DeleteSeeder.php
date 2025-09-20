<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DeleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('log_dokumen')->delete();
        DB::table('dokumen')->delete();
    }
}
