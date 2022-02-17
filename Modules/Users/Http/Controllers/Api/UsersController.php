<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Traits\Settings;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Basic\Transformers\CategoryResource;
use Modules\Books\Transformers\BookResource;
use Modules\Users\Emails\SubAccountInvitaion;
use Modules\Users\Entities\SubUserInvitation;
use Modules\Users\Entities\User;
use Modules\Users\Http\Resources\UserResource;
use Modules\Users\Traits\UserHelper;
use Modules\Users\Transformers\ProfileResource;
use Symfony\Component\HttpFoundation\Response;
use Modules\Users\Services\Api\UserService;

class UsersController extends Controller
{
    use UserHelper, Settings;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        return sendResponse(true, __('messages.profile_details'), new ProfileResource($user));
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $data = $this->userService->updateProfile($request->all(),$request->user()->id);

        if(isset($data['validationErr'])){
            return sendResponse(false, __('messages.invalid_data'), $data['errors'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return sendResponse(true, __('messages.profile_updated'), $data);
    }
}
