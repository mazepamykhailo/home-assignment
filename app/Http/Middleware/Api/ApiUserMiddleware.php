<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class ApiUserMiddleware extends BaseValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = $this->userValidator($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return $next($request);
    }
}
