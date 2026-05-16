<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Ведущий
        User::create([
            'name' => 'Чернова Наталья',
            'email' => 'master@example.com',
            'password' => Hash::make('12345678'),
            'phone' => '89123456789',
            'role' => 'master',
        ]);
        // Обычный пользователь
        User::create([
            'name' => 'Краснова Валерия',
            'email' => 'user@example.com',
            'password' => Hash::make('123456'),
            'phone' => '89223344556',
            'role' => 'user',
        ]);
    }
}
