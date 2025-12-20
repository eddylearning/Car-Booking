<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;


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
            'email_verified_at' => Carbon::now(),
        ]);
        $adminUser->assignRole('admin');

        // Create Employee
        $employeeUser = User::firstOrCreate([
            'email' => 'employee@example.com',
        ], [
            'name' => 'Employee User',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $employeeUser->assignRole('employee');

        // Create Normal User
        $normalUser = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'Normal User',
            'password' => bcrypt('password'),
             'email_verified_at' => Carbon::now(),
        ]);
        $normalUser->assignRole('user');
    }
}
