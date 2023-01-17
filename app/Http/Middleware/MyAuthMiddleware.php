<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;

class MyAuthMiddleware
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next ,String $type)
    {
        if($request->has('token') && $request->token){
            if($request->token['tokenable_type'] == $type){
                $res = $this->checkTokenInfo($request);
                if($res->getData()->status){
                    return $next($request);
                }
            }
        }
        return $this->returnError(422,'Not Authenticate !!');
    }
}
