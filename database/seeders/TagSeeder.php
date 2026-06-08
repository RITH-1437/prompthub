<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [

            'Laravel',
            'React',
            'Tailwind',
            'PHP',
            'JavaScript',
            'UIUX',
            'Cyberpunk',
            'Startup',
            'Portfolio',
            'Mobile',
            'Dark Mode',
            'Creative',
            'SEO',
            'Marketing',
            'Business',
            'Automation',
            'Freelance',
            'Ecommerce',
            'AI',
            'Productivity',
            'Dashboard',

        ];

        foreach ($tags as $tag) {

            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);

        }
    }
}
