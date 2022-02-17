<?php

namespace Modules\Users\Entities;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $guard_name = '*';
}
