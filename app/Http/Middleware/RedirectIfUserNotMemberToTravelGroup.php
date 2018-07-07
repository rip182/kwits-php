<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Cache;

use App\Travel;

class RedirectIfUserNotMemberToTravelGroup
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
        $user = $request->get('user');

        $travel = Cache::rememberForever('travel', function() use ($request) {
          return Travel::find($request->id);
        });

        if($travel) {
          $request->attributes->add(['travel' => $travel]);

          $members = Cache::remember('members', 10, function() use($travel) {
            return $travel->members;
          });

          $request->attributes->add(['members' => $members]);

          foreach($members as $member) {
            if($member->user_id == $user->id)
              return $next($request);
          }
        }

        return redirect('home');
    }
}
