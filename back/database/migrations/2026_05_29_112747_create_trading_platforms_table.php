<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trading_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->text('desc')->nullable();
            $table->string('url');
            $table->string('logo')->nullable();
            $table->string('logo_color', 20)->nullable();
            $table->string('category', 50)->default('government');
            $table->boolean('is_official')->default(false);
            $table->json('tags')->nullable();
            $table->json('translations')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trading_platforms');
    }
};
