<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(50) NOT NULL DEFAULT 'admin'");

        DB::table('users')->where('role', 'staff')->update(['role' => 'admin']);
        DB::table('users')->where('email', 'admin@qreticket.id')->update(['role' => 'superadmin']);

        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->nullOnDelete();
        });

        $ownerId = User::where('role', 'superadmin')->value('id') ?? User::query()->value('id');

        if ($ownerId) {
            DB::table('events')->whereNull('created_by')->update(['created_by' => $ownerId]);
        }
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
