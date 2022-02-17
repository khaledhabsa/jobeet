<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'user_devices';

    protected static function newFactory()
    {
        return \Modules\Users\Database\factories\UserDeviceFactory::new();
    }
}
