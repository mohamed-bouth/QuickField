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
        Schema::create('manager_account_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_code', 24)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->string('password');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_account_requests');
    }
};
