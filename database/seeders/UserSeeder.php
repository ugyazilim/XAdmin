<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin kullanıcısı
        User::firstOrCreate(
            ['email' => 'admin@obaticaret.com'],
            [
                'name' => 'Admin',
                'phone' => '0532 641 53 16',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Staff kullanıcısı
        User::firstOrCreate(
            ['email' => 'staff@obaticaret.com'],
            [
                'name' => 'Personel',
                'phone' => '0532 641 53 16',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );
    }
}
