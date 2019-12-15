<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;

class LastUserActivity
{
    /**
     * if user is login set a cache to see user activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()){
            Cache::put('user-is-online'. auth()->id(),true,Carbon::now()->addMinutes(3));
        }
        return $next($request);
    }
}
