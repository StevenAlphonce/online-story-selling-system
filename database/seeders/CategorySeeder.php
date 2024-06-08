<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define genres
        $categories = [
            'Adventure',
            'Fantasy',
            'Horror',
            'Humor',
            'Mystery',
            'Non-Fiction',
            'Paranormal',
            'Poetry',
            'Romance',
            'Science Fiction',
            'Teen Fiction',
            'Thriller'
        ];

        // Create genres
        foreach ($categories as $category) {

            Category::create(['name' => $category]);
        }
    }
}
