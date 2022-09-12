<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckDisabled {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if (auth()->check() && auth()->user()->status == 0) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            flashMessage('Your Account is disabled, please contact Admin.', 'danger');

            return redirect()->route('login');
        }

        return $next($request);
    }
}
