<?php

namespace App\Http\Middleware;

use Closure;

use App\Member;
use App\Group;

class RedirectIfNoGroup
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

        $group_ids = [];

        $members = Member::where('user_id', $user->id)->get();

        foreach($members as $member) {

          $group_ids[] = $member->group_id;

        }

        if($group_ids) {

          $groups = Group::whereIn('id', $group_ids)->orderBy('created_at', 'DESC')->get();

          $request->attributes->add(['groups' => $groups]);

          return $next($request);
        }

        return redirect('groups/create');
    }
}
