<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->string('registration_status')->default('pending')->after('is_checked_in'); // pending, approved, rejected
            $table->string('payment_status')->default('free')->after('registration_status'); // unpaid, paid, free
            $table->string('payment_method')->nullable()->after('payment_status'); // manual, xendit, free
            $table->string('payment_proof_path')->nullable()->after('payment_method');
            $table->string('admin_note')->nullable()->after('payment_proof_path'); // Untuk alasan penolakan dsb
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->dropColumn(['registration_status', 'payment_status', 'payment_method', 'payment_proof_path', 'admin_note']);
        });
    }
};
