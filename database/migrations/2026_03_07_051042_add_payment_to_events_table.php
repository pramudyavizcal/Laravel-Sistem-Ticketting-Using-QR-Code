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
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false)->after('theme_color');
            $table->decimal('price', 15, 2)->default(0)->after('is_paid');
            $table->string('payment_bank_name')->nullable()->after('price');
            $table->string('payment_bank_number')->nullable()->after('payment_bank_name');
            $table->string('payment_bank_holder')->nullable()->after('payment_bank_number');
            $table->boolean('allow_manual_transfer')->default(true)->after('payment_bank_holder');
            $table->boolean('allow_xendit')->default(false)->after('allow_manual_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['is_paid', 'price', 'payment_bank_name', 'payment_bank_number', 'payment_bank_holder', 'allow_manual_transfer', 'allow_xendit']);
        });
    }
};
