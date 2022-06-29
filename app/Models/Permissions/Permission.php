<?php

namespace App\Models\Permissions;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected string $guard_name = '*';
}
