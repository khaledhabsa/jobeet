<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'required|string',
            'pick_up_address'   => 'required|string',
            'drop_off_address'  => 'required|string',
            'vehicle_type'      => 'required|string|in:standard,premium,luxury',
            'trip_options'      => 'required|string|in:one_way,round',
            'price'             => 'required|numeric|min:0.1',
            'date'              => 'required|date|after_or_equal:today|date_format:Y-m-d H:i:s',
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
