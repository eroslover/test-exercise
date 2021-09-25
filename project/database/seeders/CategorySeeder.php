<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Class CategorySeeder
 *
 * @package Database\Seeders
 */
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Fundamentals',
            'String',
            'Algorithms',
            'Mathematics',
            'Performance',
            'Booleans',
            'Functions',
        ];

        foreach ($categories as $category) {
            Category::query()->firstOrCreate([
                'title' => $category,
            ]);
        }
    }
}
