<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'alfarisodai@gmail.com'], [
            'name' => 'Odai Alfares',
            'password' => Hash::make('ChangeThisAdminPassword'),
            'is_admin' => true,
        ]);
    }
}
