<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if user is not logged in
        if ( !Auth::check() ) {
            return redirect()->route( 'login' );
        }

        //user Role define
        $userRole = Auth::user()->role;

        //Admin
        if ( $userRole == 1 ) {
            return $next( $request );
        }

        //Admin User
        if ( $userRole == 2 ) {
            return redirect()->route( 'admin.dashboard' );
        }

        //Normal User
        if ( $userRole == 3 ) {
            return redirect()->route( 'user.dashboard' );
        }
    }
}
