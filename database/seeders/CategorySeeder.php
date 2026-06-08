<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'AI',
            'Code',
            'Design',
            'Marketing',
            'Business',
            'Productivity',
            'Video',
            'Writing',
        ];

        foreach ($categories as $category) {

            Category::create([
                'name' => $category,
                'slug' => strtolower($category),
            ]);

        }
    }
}
