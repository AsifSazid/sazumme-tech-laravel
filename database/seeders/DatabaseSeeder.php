<?php

namespace Database\Seeders;

use App\Models\Role;
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
        Role::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Super Admin',
            'alias' => 'super_admin',
            'created_by' => 'Super Admin',
            'access_control' => null
        ]);

        Role::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Admin',
            'alias' => 'admin',
            'created_by' => 'Super Admin',
            'access_control' => null
        ]);

        Role::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Client',
            'alias' => 'client',
            'created_by' => 'Super Admin',
            'access_control' => null
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'superadmin@sazumme.com',
            'phone_no' => '01684576384',
            'password' => Hash::make("87654321")
        ]);

    }
}
