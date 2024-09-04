<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        //users permissions
        Permission::create(['name' => 'create_users']);
        Permission::create(['name' => 'read_users']);
        Permission::create(['name' => 'update_users']);
        Permission::create(['name' => 'delete_users']);


        //categories permissions
        Permission::create(['name' => 'create_categories']);
        Permission::create(['name' => 'read_categories']);
        Permission::create(['name' => 'update_categories']);
        Permission::create(['name' => 'delete_categories']);


        //products permissions
        Permission::create(['name' => 'create_products']);
        Permission::create(['name' => 'read_products']);
        Permission::create(['name' => 'update_products']);
        Permission::create(['name' => 'delete_products']);


        //clients permissions
        Permission::create(['name' => 'create_clients']);
        Permission::create(['name' => 'read_clients']);
        Permission::create(['name' => 'update_clients']);
        Permission::create(['name' => 'delete_clients']);



        //roles
        $superAdminRole = Role::create(['name' => 'super_admin']);

        $adminRole = Role::create(['name' => 'admin']);


        //assign all permissions to super_admin role
        $allPermissions = Permission::all();
        $superAdminRole->givePermissionTo($allPermissions);

    }
}
