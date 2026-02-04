<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    public function run()
    {
        // User Management Permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'assign roles']);

        // Role & Permission Management Permissions
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'manage permissions']);

        // Cat Management Permissions
        Permission::create(['name' => 'create cats']);
        Permission::create(['name' => 'edit cats']);
        Permission::create(['name' => 'delete cats']);

        // Adoption Management Permissions
        Permission::create(['name' => 'view all adoptions']);
        Permission::create(['name' => 'manage adoptions']);

        // Payment Management Permissions
        Permission::create(['name' => 'view all payments']);
        Permission::create(['name' => 'refund payments']);

        // User Permissions
        Permission::create(['name' => 'view available cats']);
        Permission::create(['name' => 'request adoption']);
        Permission::create(['name' => 'make payment']);
        Permission::create(['name' => 'view my payments']);
    }
}