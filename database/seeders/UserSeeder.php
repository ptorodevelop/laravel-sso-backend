<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Persistence\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'Pedro Admin',
            'email' => 'pedro.toro@ucp.edu.co',
            'document' => '1087956872',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Duban Monsalve',
            'email' => 'duban.monsalve@ucp.edu.co',
            'document' => '456',
            'password' => Hash::make('12345678'),
        ]);
    }
}
