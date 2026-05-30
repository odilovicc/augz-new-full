<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();           // basic | pro | corporate
            $table->string('label');                    // Базовый
            $table->string('price')->nullable();        // "1 200 000" or null
            $table->string('currency')->nullable();     // "сум"
            $table->string('period')->nullable();       // "в год"
            $table->boolean('is_popular')->default(false);
            $table->string('cta_text');                 // "Вступить сейчас"
            $table->jsonb('features')->default('[]');   // [{text, included}]
            $table->jsonb('translations')->default('{}');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
