<?php

namespace App\Http\Middleware;

use Closure;

use App\Group;

class RedirectIfGroupHasNoMembers
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
        $members = $request->get('members');

        if($members->count() == 1)
          return redirect('home');

        return $next($request);
    }
}
