<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

function sendResponse($success=true, $message='', $data= [] , $code=200)
{
    if($code == 422 && is_array($data))
    {
        $errors = [];
        foreach ((array) $data as $k => $v){
                $errors[$k] = is_array($v) ? $v[0] : $v;
        }
        $data = (object) $errors;
    }


    $response = [
        'success'   => $success,
        'message'   => $message,
        'code'      => $code,
        'data'      => $data,
    ];

    return response()->json($response, $code);
}

function plansPeriod(): array
{
    return [
        'ar' => [
            1  => 'Month',
            3  => '3 Months',
            12 => 'Yearly',
        ],
        'en' => [
            1  => 'شهرى',
            3  => '3 شهور',
            12 => 'سنوى',
        ]
    ];
}

function random_strings($length_of_string, $prefix='')
{

    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.time();

    // Shuffle the $str_result and returns substring
    // of specified length
    $str = substr(str_shuffle($str_result), 0, $length_of_string);

    if(strlen($prefix) > 0){
        $str = $prefix.$str;
    }

    return $str;
}

function getFieldLocale($filed){
    return app()->getLocale() == 'en' ? 'en_'.$filed : $filed;
}

function getImageUrl($file_path){
    return Storage::disk('s3')->url($file_path);
}
