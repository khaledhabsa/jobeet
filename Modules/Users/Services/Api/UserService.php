<?php

namespace Modules\Users\Services\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Basic\Transformers\CategoryResource;
use Modules\Books\Transformers\BookResource;
use Modules\Users\Entities\User;
use Modules\Users\Repositories\Api\UserRepository;
use Modules\Users\Traits\UserHelper;
use Modules\Users\Transformers\PreferenceResource;
use Modules\Users\Transformers\ProfileResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class UserService{
    use UserHelper;
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    // update profile
    public function updateProfile($request, $userID)
    {
        $validator = Validator::make($request, [
            'name'  => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,'.$userID,
            'password' => 'nullable|string',
            'profile_image' => 'nullable|image'
        ]);

        if ($validator->fails()){
            return ['validationErr' => true, 'errors' => $validator->errors()->toArray()];
        }

        return new ProfileResource($this->userRepository->updateProfile($request, $userID));
    }
}
