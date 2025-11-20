<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



// Create roles
$superAdmin = Role::create(['name' => 'super-admin']);
$manager = Role::create(['name' => 'manager']);
$employee = Role::create(['name' => 'employee']);

// Create permissions
Permission::create(['name' => 'manage users']);
Permission::create(['name' => 'edit posts']);
Permission::create(['name' => 'view reports']);

// Assign permissions to roles
$superAdmin->givePermissionTo(Permission::all()); // super admin gets all permissions
$manager->givePermissionTo(['edit posts', 'view reports']);
$employee->givePermissionTo(['view reports']);

    }
}
