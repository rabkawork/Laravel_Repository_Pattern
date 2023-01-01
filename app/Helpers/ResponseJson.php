<?php

namespace App\Helpers;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class ResponseJson extends \Illuminate\Http\Response
{
    public static function responseSuccess(string $message, array $data): JsonResponse
    {
        $message['status']  = true;
        $message['message'] = $message;
        $message['data']    = $data;
        return response()->json($message, self::HTTP_OK);
    }
    
    public static function responseBadOrError(string $message, array $error, int $httpCode): JsonResponse
    {
        $message['status']  = false;
        $message['message'] = $message;
        $message['error'] = $error;
        return response()->json($message, $httpCode);
    }


}