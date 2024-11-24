<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            ['name' => 'Aktif', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nonaktif', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
