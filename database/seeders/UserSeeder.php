<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Manima',
            'email' => 'manimamarien08@gmail.com',
            'phone' => '2222222222',
            'password' => Hash::make('password123'), // mot de passe fictif
            'role' => 'gerant',
        ]);

        User::create([
            'name' => 'Alice Test',
            'email' => 'alice@example.com',
             'phone' => '0827429136',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Jean Client',
             'phone' => '0000000000',
            'email' => 'jean@example.com',
            'password' => Hash::make('clientpass'),
            'role' => 'user',
        ]);
    }
}
