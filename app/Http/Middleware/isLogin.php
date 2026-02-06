<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isLogin
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
        // CHECK IF USER IS AUTHENTICATED
        if (!Auth::user()) {
            return redirect('/login');
            // return response()->view('pages.401');
        }

        // // IF AUTH-USER IS NOT CPR-ADMIN
        // if (!(Auth::user()->id == 1) || !(Auth::user()->role_id == 1)) {

        //     Auth::logout();
        //     return redirect('/login');
        //     // return response()->view('pages.403');
        // }

        return $next($request);
    }
}