<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{

    protected $guards;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;
        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $subdomain = Route::input('subdomain');
            if (Arr::first($this->guards) === 'admin') {
                return route('admin.login');
            } else {
                return route('client.login', $subdomain);
            }

            return route('login');
        }
    }
}
