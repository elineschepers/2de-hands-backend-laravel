<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Specify any roles with permissions here
     * Please note that this is in ascending order.
     * Meaning that the latest item will receive all permissions from the above items.
     * @var array[]
     */
    protected $roles = [
        [
            'name' => 'default',
            'permissions' => [
                'offers.show',
                'offers.create',
                'offers.list',

                'programs.list',
                'courses.list',
            ],
        ],
        [
            'name' => 'mod',
            'permissions' => [
                'offers.edit',
                'offers.delete',

                'programs.show',
                'programs.create',
                'programs.edit',
                'programs.delete',

                'courses.show',
                'courses.create',
                'courses.edit',
                'courses.delete',

                'users.list',
            ]
        ],
        [
            'name' => 'admin',
            'permissions' => [
                'users.show',
                'users.edit',
                'users.delete',
                'users.ban',
                'users.unban',

                'permissions.show',
                'permissions.assign',

                'activities.show',
            ]
        ]
    ];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [];
        foreach ($this->roles as $role) {
            $db_role = Role::findOrCreate($role['name'], '*');

            foreach ($role['permissions'] as $permission) {
                $permissions[] = Permission::findOrCreate($permission, '*');
            }

            // Assign existing + new permissions
            foreach ($permissions as $permission) {
                /** @var Permission */
                $permission->assignRole($db_role);
            }
        }
    }
}
