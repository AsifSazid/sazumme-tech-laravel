<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use App\Models\Wing;
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

        Admin::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'superadmin@sazumme.com',
            'phone_no' => '01684576384',
            'password' => Hash::make("87654321")
        ]);

        User::factory()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Asif Mostofa Sazid',
            'email' => 'asif83sazid@gmail.com',
            'phone_no' => '01751906710',
            'password' => Hash::make("12345678")
        ]);

        // Wings
        Wing::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'title' => 'SazTech - A Software Firm',
            'icon_code' => 'fas fa-code icon',
            'short_description' => 'Building modern web application that scales with your vision.',
            'created_by' => '1'
        ]);

        Wing::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'title' => 'SazEdify - An EduTech',
            'icon_code' => 'fas fa-graduation-cap icon',
            'short_description' => 'Empowering learners with next-gen educational tools.',
            'created_by' => '1'
        ]);
    }
}
