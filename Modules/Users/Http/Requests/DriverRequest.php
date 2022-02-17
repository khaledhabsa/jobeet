<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DriverRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|string',
            'email'                 => 'required|email|unique:users,email',
            'profile_image'         => 'nullable|image',
            'license_image'         => 'required|image',
            'criminal_record_image' => 'required|image',
            'password'              => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return [
            'name' => __('messages.validate_name'),
            'email.required' => __('messages.validate_required_email'),
            'email.email' => __('messages.validate_email'),
            'email.unique' => __('messages.validate_unique_email'),
            'password' => __('messages.validate_password'),
        ];
    }

    protected function failedValidation(Validator $validator) : void
    {
        $res = sendResponse( false,'invalid data', $validator->errors()->toArray(), 422);
        throw new HttpResponseException($res);
    }
}
