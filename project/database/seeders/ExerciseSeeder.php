<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class ExerciseSeeder
 *
 * @package Database\Seeders
 */
class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exercises')->truncate();
        Exercise::factory(500)->create();
    }
}
