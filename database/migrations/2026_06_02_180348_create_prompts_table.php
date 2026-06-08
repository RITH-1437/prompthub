<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prompts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->text('description')
                ->nullable();

            $table->longText('prompt_content');

            $table->enum('visibility', ['public', 'private'])
                ->default('public');

            $table->unsignedBigInteger('copy_count')
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
