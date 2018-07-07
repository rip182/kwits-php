<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use App\User;

class RedirectIfNotLoggedIn
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
        $user = Cache::rememberForever('user', function() {
          return User::find(Auth::id());
        });

        if($user) {

          $request->attributes->add(['user' => $user]);

          return $next($request);

        }

        return redirect('login');
    }
}
