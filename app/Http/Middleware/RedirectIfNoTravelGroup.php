<?php

namespace App\Http\Middleware;

use Closure;

use App\Member;
use App\Travel;

class RedirectIfNoTravelGroup
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

        $travel_ids = [];

        $members = Member::where('user_id', $user->id)->get();

        foreach($members as $member) {

          $travel_ids[] = $member->travel_id;

        }

        if($travel_ids) {

          $travels = Travel::whereIn('id', $travel_ids)->orderBy('created_at', 'DESC')->get();

          $request->attributes->add(['travels' => $travels]);

          return $next($request);
        }

        return redirect('travels/create');
    }
}
