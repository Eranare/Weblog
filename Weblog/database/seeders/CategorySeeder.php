<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Pets',
            'Travel',
            'Food',
            'Technology',
            'Health & Fitness',
            'Fashion',
            'DIY & Crafts',
            'Finance',
            'Sports',
            'Gaming'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
