<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_actions')
            ->insert([
                [
                    'name' => 'view',
                    'description' => 'Hak untuk mengakses halaman',
                ],
                [
                    'name' => 'add',
                    'description' => 'Tombol aksi untuk menambah data',
                ],
                [
                    'name' => 'edit',
                    'description' => 'Tombol aksi untuk mengedit data',
                ],
                [
                    'name' => 'delete',
                    'description' => 'Tombol aksi untuk menghapus data',
                ]
            ]);
    }
}
