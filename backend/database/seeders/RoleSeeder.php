<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get existing roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Define and create permissions
        $permissions = [
            // User Management
            'manage users',
            'assign roles',

            // Role & Permission Management
            'manage roles',
            'manage permissions',

            // Cat Management
            'create cats',
            'edit cats',
            'delete cats',

            // Adoption Management
            'view all adoptions',
            'manage adoptions',

            // Payment Management
            'view all payments',
            'refund payments',

            // User-specific Permissions
            'view available cats',
            'request adoption',
            'make payment',
            'view my payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());

        // Assign specific permissions to Admin
        $adminRole->syncPermissions([
            'create cats',
            'edit cats',
            'delete cats',
            'view all adoptions',
            'manage adoptions',
        ]);

        // Assign specific permissions to User
        $userRole->syncPermissions([
            'view available cats',
            'request adoption',
            'make payment',
            'view my payments',
        ]);

        // Assign roles to specific users (optional)
        $superAdmin = User::find(1); // Assuming the first user is the super admin
        if ($superAdmin) {
            $superAdmin->assignRole('super-admin');
        }

        $admin = User::find(2); // Assuming the second user is an admin
        if ($admin) {
            $admin->assignRole('admin');
        }

        $user = User::find(3); // Assuming the third user is a normal user
        if ($user) {
            $user->assignRole('user');
        }
    }
}