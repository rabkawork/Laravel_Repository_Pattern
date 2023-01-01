<?php

namespace App\Helpers;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class ResponseJson extends \Illuminate\Http\Response
{
    public static function responseSuccess($message, $success)
    {
        $data['status']  = true;
        $data['message'] = $message;
        $data['data']    = $success;
        return response()->json($data, self::HTTP_OK);
    }

    public static function responseBadOrError($message, $error, $httpCode)
    {
        $data['status']  = false;
        $data['message'] = $message;
        $data['error']   = $error;
        return response()->json($data, $httpCode);
    }
}
