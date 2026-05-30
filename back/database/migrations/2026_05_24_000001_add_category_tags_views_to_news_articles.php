<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('category', 32)->default('news')->after('is_featured');
            $table->string('source', 128)->nullable()->after('category');
            $table->jsonb('tags')->nullable()->after('source');
            $table->unsignedBigInteger('views')->default(0)->after('tags');

            $table->index('category');
            $table->index('views');
        });

        // GIN index for tags JSONB array — enables fast @> queries
        DB::statement('CREATE INDEX news_articles_tags_gin ON news_articles USING GIN (tags)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS news_articles_tags_gin');

        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['views']);
            $table->dropColumn(['category', 'source', 'tags', 'views']);
        });
    }
};
