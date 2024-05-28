<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'userRoll' =>  Auth::user() ? (Auth::user()->role == 1 ? 'superAdmin' : (Auth::user()->role == 2 ? 'admin' : 'user')) : null,
            'auth' => Auth::user() ? [
                'user' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role,
                ],
            ] : null,
        ];
    }
}
