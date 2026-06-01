<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('category')->nullable()->after('id');
            $table->jsonb('tags')->default('[]')->after('desc');
            $table->dropColumn(['image', 'tag']);
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['category', 'tags']);
            $table->string('image', 500)->nullable();
            $table->string('tag')->nullable();
        });
    }
};
