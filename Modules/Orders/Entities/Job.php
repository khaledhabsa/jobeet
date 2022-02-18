<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Job extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes,HasRoles;


    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Orders\Database\factories\JobFactory::new();
    }
}
