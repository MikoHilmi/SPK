<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Data Master',
                'order' => 0,
                'icons' => 'database',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Penilaian',
                'order' => 0,
                'icons' => 'sort-numeric-up-alt',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Manajemen User',
                'order' => 0,
                'icons' => 'person-gear',
                'status' => 'active',
            ]);
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Pengaturan',
                'order' => 0,
                'icons' => 'gear',
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Periode',
                'url' => '/periode',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Siswa',
                'url' => '/siswa',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Kriteria',
                'url' => '/kriteria',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Sub kriteria',
                'url' => '/crips',
                'icons' => '',
                'order' => 4,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Data Penilaian Siswa',
                'url' => '/penilaian',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 3,
                'name_menu' => 'User',
                'url' => '/user',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 3,
                'name_menu' => 'Group',
                'url' => '/group',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 4,
                'name_menu' => 'Pengaturan Aplikasi',
                'url' => '/pengaturan-aplikasi',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 4,
                'name_menu' => 'Menu',
                'url' => '/menu',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 4,
                'name_menu' => 'Aksi',
                'url' => '/aksi',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);

        DB::table('actions')
            ->insert([
                'menu_id' => 7,
                'master_action_id' => 1,
            ]);

        DB::table('action_groups')
            ->insert([
                'action_id' => 1,
                'group_id' => 1,
            ]);
    }
}
