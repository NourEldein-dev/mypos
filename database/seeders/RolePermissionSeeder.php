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
        
        //permissions
        Permission::create(['name' => 'create_users']);
        Permission::create(['name' => 'read_users']);
        Permission::create(['name' => 'update_users']);
        Permission::create(['name' => 'delete_users']);

        //roles
        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo(['create_users' , 'read_users' , 'update_users' , 'delete_users']);

        $role = Role::create(['name' => 'admin']);

    }
}
