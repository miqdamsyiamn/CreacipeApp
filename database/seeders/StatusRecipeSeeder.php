<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusRecipe;

class StatusRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Pending'],
            ['name' => 'Approved'],
            ['name' => 'Declined'],
        ];

        foreach ($statuses as $status) {
            StatusRecipe ::create($status);
        }
    }
}
