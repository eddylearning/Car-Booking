<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Create Admin
        $adminUser = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole('admin');

        // Create Employee
        $employeeUser = User::firstOrCreate([
            'email' => 'employee@example.com',
        ], [
            'name' => 'Employee User',
            'password' => bcrypt('password'),
        ]);
        $employeeUser->assignRole('employee');

        // Create Normal User
        $normalUser = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'Normal User',
            'password' => bcrypt('password'),
        ]);
        $normalUser->assignRole('user');
    }
}
