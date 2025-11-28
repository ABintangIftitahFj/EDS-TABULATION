<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admineds123@gmail.com'],
            [
                'name' => 'Administrator EDS',
                'password' => Hash::make('edsupi123#%'),
                'is_admin' => true,
            ]
        );
    }
}
