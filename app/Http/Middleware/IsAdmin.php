<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponderTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    use ApiResponderTrait;

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (Gate::allows('isAdmin')) {
             return $next($request);
         }
        return $this->fail(trans('auth.unauthorized'), Response::HTTP_UNAUTHORIZED);
    }
}
