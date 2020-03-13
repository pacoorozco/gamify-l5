<?php

namespace Gamify\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class OnlyAjax
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->ajax()) {
            return response(view('errors.403'), ResponseCode::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
