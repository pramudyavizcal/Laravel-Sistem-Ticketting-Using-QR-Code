<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('ticket_code')->unique(); // UUID as QR content
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('seat_number')->nullable();
            $table->string('ticket_type')->default('Regular'); // VIP, Regular, VVIP, etc.
            $table->string('institution')->nullable(); // Universitas/Perusahaan
            $table->string('faculty')->nullable();     // Untuk wisuda
            $table->string('major')->nullable();       // Untuk wisuda
            $table->boolean('is_checked_in')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->string('checked_in_by')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
