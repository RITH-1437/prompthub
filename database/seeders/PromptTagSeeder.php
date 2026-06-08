<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromptTagSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prompt_tag')->insert([

            ['prompt_id' => 1, 'tag_id' => 1],
            ['prompt_id' => 1, 'tag_id' => 2],
            ['prompt_id' => 1, 'tag_id' => 3],
            ['prompt_id' => 1, 'tag_id' => 8],
            ['prompt_id' => 1, 'tag_id' => 9],

            ['prompt_id' => 2, 'tag_id' => 7],
            ['prompt_id' => 2, 'tag_id' => 12],

            ['prompt_id' => 3, 'tag_id' => 1],
            ['prompt_id' => 3, 'tag_id' => 4],
            ['prompt_id' => 3, 'tag_id' => 21],

            ['prompt_id' => 4, 'tag_id' => 19],
            ['prompt_id' => 4, 'tag_id' => 20],
            ['prompt_id' => 4, 'tag_id' => 16],

        ]);
    }
}
