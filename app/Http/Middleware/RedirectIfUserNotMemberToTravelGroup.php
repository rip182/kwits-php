<?php

namespace App\Http\Middleware;

use Closure;

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
        $travel = Travel::find($request->id);

        if($travel) {
          $request->attributes->add(['travel' => $travel]);

          $members = $travel->members;
          $request->attributes->add(['members' => $travel->members()->where('user_id', '!=', $user->id)->get()]);

          foreach($members as $member) {
            if($member->user_id == $user->id)
              return $next($request);
          }
        }

        return redirect('home');
    }
}
