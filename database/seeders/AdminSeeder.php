<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@qreticket.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@qreticket.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@qreticket.id'],
            [
                'name' => 'Staff Scanner',
                'email' => 'staff@qreticket.id',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
            ]
        );
    }
}
