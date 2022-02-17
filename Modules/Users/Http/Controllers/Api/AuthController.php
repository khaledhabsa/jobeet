<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Settings;
use Carbon\Carbon;
use Ferdous\OtpValidator\Object\OtpRequestObject;
use Ferdous\OtpValidator\Object\OtpValidateRequestObject;
use Ferdous\OtpValidator\OtpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Users\Emails\WelcomeEmail;
use Modules\Users\Entities\Transaction;
use Modules\Users\Entities\User;
use Modules\Users\Entities\UserDevice;
use Modules\Users\Http\Requests\Register;
use Modules\Users\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Modules\Users\Traits\UserHelper;
use Vinkla\Hashids\Facades\Hashids;
use App\Traits\Subscriptions;

class AuthController extends Controller
{
    use UserHelper, Settings, Subscriptions;

    public function companyRegister(Register $request): JsonResponse
    {
        $user = new user();
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->user_type = 'company';
        $user->save();
        $user->assignRole(1);

        $user->token = $user->createToken('authToken')->accessToken;

//        \Mail::to($user->email)->send(new WelcomeEmail(['name' => $user->name]));

        return sendResponse(true, __('messages.successfully_registered'), new UserResource($user), Response::HTTP_CREATED);
    }

    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ],[
            'email.required'    => __('messages.validate_required_email'),
            'email.email'       => __('messages.validate_email'),
            'email.exists'      => __('messages.validate_exists_email'),
            'password.*'        => __('messages.validate_password'),
        ]);

        if ($validator->fails()) {
            return sendResponse(false, __('messages.invalid_data'), $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            if($request->device_token) {
                $this->saveDeviceToken($request->device_token, $user->id);
            }

            $user->token = auth()->user()->createToken('authToken')->accessToken;
            return sendResponse(true, __('messages.successfully_login'), new UserResource($user), Response::HTTP_CREATED);
        }
        else{
            return sendResponse(false, __('messages.credentials_errors'), (object) null, Response::HTTP_UNAUTHORIZED);
        }
    }

    //
    public function socialLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'nullable|string',
            'email'             => 'nullable|email',
            'social_provider'   => 'required|string',
            'social_id'         => 'required|string',
        ]);

        if ($validator->fails()) {
            return sendResponse(false, __('messages.invalid_data'), $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('social_id', $request->input('social_id'))
            ->where('social_provider', $request->input('social_provider'))
            ->first();

        if(!$user){
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|unique:users,email',
            ],[
                'email.email' => __('messages.validate_email'),
                'email.unique' => __('messages.validate_unique_email'),
            ]);

            if ($validator->fails()) {
                return sendResponse(false, __('messages.invalid_data'), $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = User::create($request->all());
        }

        $user->token()->revoke();
        $user->token = $user->createToken('authToken')->accessToken;
        return sendResponse(true, __('messages.successfully_login'), new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function otpRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ],[
            'email.required'    => __('messages.validate_required_email'),
            'email.email'       => __('messages.validate_email'),
            'email.exists'      => __('messages.validate_exists_email'),
        ]);

        if ($validator->fails()) {
            return sendResponse(false, __('messages.invalid_data'), $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

       $request = OtpValidator::requestOtp(
            new OtpRequestObject($request->email, rand(0,99999), 'reset-password', $request->email)
        );

        if ($request['code'] === 201){
            return sendResponse(true, __('messages.otp_code_sent'), [
                'otp-token' => $request['uniqueId']
            ], Response::HTTP_CREATED);
        }

        return sendResponse(false, __('messages.something_went_wrong'), (object) null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validateOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'otp-token' => 'required|string',
            'otp' => 'required|string|min:6|max:6',
        ],[
            'otp'   => __('messages.validate_otp')
        ]);

        if ($validator->fails()) {
            return sendResponse(false, __('messages.invalid_data'), $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $uniqId = $request->input('otp-token');
        $otp = $request->input('otp');

        $res = OtpValidator::validateOtp(
            new OtpValidateRequestObject($uniqId,$otp)
        );

        if ($res['code'] !== 200){
            return sendResponse(false, __('messages.invalid_or_expired_code'), (object) null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $res['requestId'])->firstOrFail();
        return sendResponse(true, __('messages.otp_code_verified'), [
            'token' => $user->createToken('authToken')->accessToken
        ], Response::HTTP_OK);

    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ],[
            'password.*' => __('messages.validate_password')
        ]);

        if ($validator->fails()) {
            return sendResponse(false, __('messages.invalid_data'), $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = auth('api')->user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return sendResponse(true, __('messages.password_changed_successfully'), (object) null, Response::HTTP_OK);
    }

    public function logout(Request $request){
        $request->user('api')->token()->revoke();
        return sendResponse(true, __('messages.logged_out_successfully'), (object) null, Response::HTTP_OK);
    }

    private function saveDeviceToken($token, $user_id){
        if(!UserDevice::where('device_token', $token)->where('user_id', $user_id)->exists()){
            UserDevice::insert(['device_token' => $token, 'user_id'=> $user_id, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
