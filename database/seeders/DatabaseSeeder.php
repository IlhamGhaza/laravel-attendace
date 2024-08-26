<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // \App\Models\Role::factory()->create([
        //     'name' => 'Admin',
        //     'description' => 'Admin',
        // ]);
        //  \App\Models\Role::factory()->create([
        //     'name' => 'Staff',
        //     'description' => 'Staff',
        // ]);
        // \App\Models\Role::factory()->create([
        //     'name' => 'User',
        //     'description' => 'User',
        // ]);
        \App\Models\User::factory()->create([
            'name' => 'Test Ilham ',
            'email' => 'ilham@admin.com',
            // 'role_id' => 1,
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test user ',
            'email' => 'user@user.com',
            // 'role_id' => 3,
            'password' => Hash::make('45678912'),

        ]);

        //data dumy for company
        \App\Models\Company::factory()->create([
            'name' => 'Company 1',
            'description' => 'Company 1',
            'address' => 'Jl. Raya jalanjalan No. 1',
            'phone' => '081234567890',
            'email' => '3v5wL@example.com',
            'latitude' => '',
            'longitude' => '107.6299',
            'radius_km' => '0.5',
        ]);
        //call seed
        // $this->call([
        //     CompanySeeder::class,
        // ]);
    }
}
