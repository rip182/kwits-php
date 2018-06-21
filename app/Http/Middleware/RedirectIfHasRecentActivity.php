<?php

namespace App\Http\Middleware;

use Closure;

use App\Activity;

class RedirectIfHasRecentActivity
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

        $activity = $user->activities()->where('type', 'created_expense')->first();

        if($activity) {
          $expensePayment = $user->expensePayment($activity->subject_id);

          if($expensePayment)
            return redirect('groups/'.$expensePayment->payable->group_id);
        }

        return $next($request);
    }
}
