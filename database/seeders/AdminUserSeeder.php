<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@caymi.com'],
            [
                'name'     => 'Administrador',
                'password' => '123456', // Laravel lo hashea automáticamente
                'role'     => 'admin',
            ]
        );
    }
}