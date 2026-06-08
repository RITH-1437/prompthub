<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_prompt', function (Blueprint $table) {

            $table->id();

            $table->foreignId('collection_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('prompt_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_prompt');
    }
};
