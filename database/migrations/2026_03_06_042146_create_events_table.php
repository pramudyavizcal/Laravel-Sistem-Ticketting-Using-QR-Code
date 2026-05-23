<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['wisuda', 'seminar', 'konser', 'workshop']);
            $table->text('description')->nullable();
            $table->string('venue');
            $table->date('event_date');
            $table->time('event_time');
            $table->integer('quota')->default(0);
            $table->string('organizer')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('theme_color', 7)->default('#6C63FF');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
