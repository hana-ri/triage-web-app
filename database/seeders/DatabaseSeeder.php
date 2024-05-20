<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);

        \App\Models\User::factory(5)->create();
        \App\Models\User::factory(5)->unverified()->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Mohamad Rizal Hanafi',
            'email' => 'hanari@upi.edu',
            'password' => bcrypt('Ggwp2001'),
        ]);

        $user->syncRoles($role->name);
    }
}
