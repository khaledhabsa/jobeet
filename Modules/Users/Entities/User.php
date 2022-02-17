<?php

namespace Modules\Users\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Category;
use Modules\Books\Entities\Book;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes,HasRoles;
//    use HasRoles {
//        hasPermissionTo as hasPermissionToOriginal;
//    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'uuid',
        'email',
        'password',
        'social_provider',
        'social_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function getCompanyIdAttribute(){
        return $this->parent_id ?? $this->id;
    }
    public function devices(){
        return $this->hasMany(UserDevice::class);
    }

//    public function hasPermissionTo($permission, $guardName = '*'): bool
//    {
//        return $this->hasPermissionToOriginal($permission, $guardName);
//    }
//    protected function getDefaultGuardName(): string
//    {
//        return '*';
//    }
}
