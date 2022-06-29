<?php


namespace App\Models\Permissions;


class Role extends \Spatie\Permission\Models\Role
{
    protected string $guard_name = '*';
}
