<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAdmin extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|string|min:3',
            'email'                 => 'required|email|unique:users,email,'.$this->admin->id,
            'password'              => 'nullable|string|confirmed|min:8',
            'profile_image_file'    => 'nullable|image'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
