<?php

namespace Modules\Users\Repositories\Api;

use App\Traits\Settings;
use App\Traits\UploadFiles;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Entities\Preferences;
use Modules\Users\Entities\User;
use Modules\Users\Traits\UserHelper;

class UserRepository{
    use UploadFiles, UserHelper, Settings;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function updateProfile($request, $userID)
    {
        $user = $this->user->findOrFail($userID);
        $user->name = $request['name'] ?? $user->name;
        $user->email = $request['email'] ?? $user->email;
        $user->password = isset($request['password']) ? Hash::make($request['password']) : $user->password;

        if (isset($request['profile_image'])){
            $user->profile_image = $this->UpdateS3File($request['profile_image'], 'profiles', $user->profile_image, true);
        }

        $user->save();

        return $user->fresh();
    }
}
