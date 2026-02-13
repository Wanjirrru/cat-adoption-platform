<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ─── Roles ───
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);
        $userRole       = Role::firstOrCreate(['name' => 'user']);

        // ─── Permissions ───
        $permissions = [
            'manage users',
            'assign roles',
            'manage roles',
            'manage permissions',
            'create cats',
            'edit cats',
            'delete cats',
            'view all adoptions',
            'manage adoptions',
            'view all payments',
            'refund payments',
            'view available cats',
            'request adoption',
            'make payment',
            'view my payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Super admin gets everything
        $superAdminRole->syncPermissions(Permission::all());

        // Admin gets most admin powers
        $adminRole->syncPermissions([
            'create cats',
            'edit cats',
            'delete cats',
            'view all adoptions',
            'manage adoptions',
            'manage users',
            'assign roles',
        ]);

        // Normal user gets only client permissions
        $userRole->syncPermissions([
            'view available cats',
            'request adoption',
            'make payment',
            'view my payments',
        ]);

        // ─── Create / assign users explicitly (no ID assumptions) ───

        // Super Admin
        $super = User::firstOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name'     => 'Super Administrator',
                'password' => Hash::make('password123'),
            ]
        );
        $super->assignRole('super-admin');

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@catadopt.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        // Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@catadopt.com'],
            [
                'name'     => 'Regular User',
                'password' => Hash::make('password123'),
            ]
        );
        $user->assignRole('user');
    }
}