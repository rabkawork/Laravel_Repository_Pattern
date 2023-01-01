<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseJson;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        abort(ResponseJson::responseBadOrError("You don't have access for this endpoint", [], ResponseJson::HTTP_FORBIDDEN));
    }
}
