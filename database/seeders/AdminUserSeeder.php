<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin default. GANTI email & password ini setelah login pertama.
        User::firstOrCreate(
            ['email' => 'admin@ganeshaflame.co.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
    }
}
