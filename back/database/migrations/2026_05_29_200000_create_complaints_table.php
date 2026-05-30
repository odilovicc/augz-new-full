<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('track_code', 32)->unique();

            // Violation details
            $table->string('organization')->nullable();
            $table->string('tender_number')->nullable();
            $table->date('violation_date')->nullable();
            $table->text('description');

            // Sender
            $table->boolean('anonymous')->default(false);
            $table->string('name')->nullable();
            $table->string('sender_org')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Admin
            $table->enum('status', ['new', 'in_review', 'responded', 'closed'])->default('new');
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
