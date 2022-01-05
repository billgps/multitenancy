<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'staff']);
        Role::firstOrCreate(['name' => 'visit']);

        $permissions = array(
            'create inventory',
            'read inventory',
            'update inventory',
            'delete inventory',
            'create record',
            'read record',
            'update record',
            'delete record',
            'create condition',
            'read condition',
            'update condition',
            'delete condition',
            'create device',
            'read device',
            'update device',
            'delete device',
            'create identity',
            'read identity',
            'update identity',
            'delete identity',
            'create brand',
            'read brand',
            'update brand',
            'delete brand',
            'create room',
            'read room',
            'update room',
            'delete room',
            'create complain',
            'read complain',
            'update complain',
            'delete complain',
            'create response',
            'read response',
            'update response',
            'delete response',
            'create activity',
            'read activity',
            'update activity',
            'delete activity',
            'create aspak',
            'read aspak',
            'update aspak',
            'delete aspak',
            'create consumable',
            'read consumable',
            'update consumable',
            'delete consumable',
            'create maintenance',
            'read maintenance',
            'update maintenance',
            'delete maintenance',
            'create asset',
            'read asset',
            'update asset',
            'delete asset',
        );

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        Role::where('name', 'admin')->each(function($role) use ($permissions) {
            $role->syncPermissions($permissions);
        });

        Role::where('name', 'staff')->each(function($role) use ($permissions) {
            $role->syncPermissions(array(
                'create inventory',
                'read inventory',
                'update inventory',
                'delete inventory',
                'create record',
                'read record',
                'update record',
                'delete record',
                'create condition',
                'read condition',
                'update condition',
                'delete condition',
                'create complain',
                'read complain',
                'update complain',
                'delete complain',
                'create response',
                'read response',
                'update response',
                'delete response',
                'create consumable',
                'read consumable',
                'update consumable',
                'delete consumable',
                'create maintenance',
                'read maintenance',
                'update maintenance',
                'delete maintenance',
                'create asset',
                'read asset',
                'update asset',
                'delete asset',
            ));
        });

        Role::where('name', 'visit')->each(function($role) use ($permissions) {
            $role->syncPermissions(array(
                'read inventory',
                'read record',
                'read condition',
                'create complain',
                'read complain',
                'update complain',
                'delete complain',
                'create response',
                'read response',
                'read consumable',
                'read maintenance',
                'read asset',
            ));
        });
    }
}
