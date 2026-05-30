<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Drop old enum, recreate with new statuses
            $table->string('status', 32)->default('new')->change();
        });

        // Recreate as string (already done above) — add response fields
        Schema::table('complaints', function (Blueprint $table) {
            $table->text('response_message')->nullable()->after('admin_note');
            $table->json('response_files')->nullable()->after('response_message');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['response_message', 'response_files']);
        });
    }
};
