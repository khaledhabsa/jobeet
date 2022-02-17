<?php

namespace Modules\Users\Entities;

class Role extends \Spatie\Permission\Models\Role
{
    protected $guard_name = '*';
}
