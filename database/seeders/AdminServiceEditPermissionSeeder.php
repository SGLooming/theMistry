<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminServiceEditPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'eProviders.services']);
        $permission1 = Permission::create(['name' => 'eProviders.services.delete']);

        $role = Role::findByName('admin');
        
        $role->givePermissionTo($permission);
        $role->givePermissionTo($permission1);
    }
}
