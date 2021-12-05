<?php

namespace Database\Seeders;

use App\Models\Word;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(0, 10) as $item) {
            Word::factory()
                ->count(random_int(2, 8))
                ->hasGroups(1)
                ->create();
        }
    }
}
