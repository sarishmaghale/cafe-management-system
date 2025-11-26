<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles
        $roles = ['admin', 'receptionist', 'kitchen', 'waiter', 'manager'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        //create permissions
        // $manageProducts = Permission::create([
        //     'name' => 'manage products'
        // ]);

        //Assign permissions to roles
        // $admin->givePermissionTo(($manageProducts));
    }
}
