<?php

namespace Database\Seeders;

use App\Models\Prompt;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    public function run(): void
    {
        Prompt::insert([

            [
                'user_id' => 1,
                'category_id' => 2,
                'title' => 'Modern SaaS Landing Page',
                'slug' => 'modern-saas-landing-page',
                'prompt_content' => 'Create a modern SaaS landing page with glassmorphism cards, dark UI, responsive layout, premium typography, animated CTA buttons, dashboard sections, testimonials, and startup branding inspired by modern AI companies.',
                'visibility' => 'public',
                'views_count' => 205,
                'copy_count' => 44,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 1,
                'category_id' => 7,
                'title' => 'Anime Character Portrait',
                'slug' => 'anime-character-portrait',
                'prompt_content' => 'Generate an ultra detailed anime cyberpunk girl portrait in Tokyo night with neon lighting, cinematic atmosphere, dramatic reflections, futuristic outfit, glowing eyes, and realistic textures.',
                'visibility' => 'public',
                'views_count' => 327,
                'copy_count' => 88,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 1,
                'category_id' => 2,
                'title' => 'Laravel Admin Dashboard',
                'slug' => 'laravel-admin-dashboard',
                'prompt_content' => 'Build a professional Laravel admin dashboard using Tailwind CSS with analytics cards, charts, dark mode support, authentication system, responsive sidebar navigation, and modern SaaS design.',
                'visibility' => 'public',
                'views_count' => 500,
                'copy_count' => 122,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'AI Productivity Assistant',
                'slug' => 'ai-productivity-assistant',
                'prompt_content' => 'Create an AI assistant interface that helps users manage tasks, summarize notes, generate productivity reports, automate workflows, and improve personal efficiency with clean futuristic UI.',
                'visibility' => 'public',
                'views_count' => 640,
                'copy_count' => 201,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
