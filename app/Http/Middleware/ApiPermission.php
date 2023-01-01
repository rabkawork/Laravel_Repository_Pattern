<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseJson;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class ApiPermission
{

    public function handle(Request $request, Closure $next, ...$permission): JsonResponse
    {
        $user = Auth::check() ? Auth::user() : "";
        $grouping = [];
        foreach ($permission as $role) {
            $grouping[] = $role == 'owner' ? 1 : ($role == 'regular' ? 2 : ($role == 'premium' ? 3 : 0));
        }
        if ($user && in_array($user['permission'], $grouping, true)) {
            return $next($request);
        }
        return ResponseJson::responseBadOrError("You don't have access for this endpoint", [], ResponseJson::HTTP_FORBIDDEN);
    }

}
