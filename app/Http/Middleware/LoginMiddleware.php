<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use DB;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $valueHasLogin = Session::get('hasLogin', 0);

        if ($valueHasLogin == 0) {
            return redirect('/login');
        } elseif ($valueHasLogin == 1) {
            // $system = DB::select("SELECT * FROM system_tb where system_name ='ois'");

            // if ($system[0]->system_status == 'N') {
            //     //\Session::flush();
            //     return redirect('/maintenance');
            // }
        }
        return $next($request);
    }
}