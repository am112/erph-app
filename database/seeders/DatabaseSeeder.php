<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => UserType::ADMIN
        ]);
        Role::create([
            'name' => UserType::SUPERVISOR
        ]);
        Role::create([
            'name' => UserType::SCHOOL
        ]);

        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole(UserType::ADMIN);
        
        $this->call(WeekSeeder::class);
        $this->call(MonthSeeder::class);
        \App\Models\Curricula::factory(10)->create();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
