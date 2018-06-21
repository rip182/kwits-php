<?php

namespace App\Http\Middleware;

use Closure;

use App\Group;

class RedirectIfUserNotMemberToGroup
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
        $group = Group::find($request->id);

        if($group) {
          $request->attributes->add(['group' => $group]);

          $members = $group->members;
          $request->attributes->add(['members' => $group->members()->where('user_id', '!=', $user->id)->get()]);

          foreach($members as $member) {
            if($member->user_id == $user->id)
              return $next($request);
          }
        }

        return redirect('home');
    }
}
