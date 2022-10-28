<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    /*
        CHANGE LOG

        2022-10-22:
            - Add Manager to the access group
                * Juncel
    */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->usertype != 3 && (!Auth::check() || Auth::user()->is_admin == 0)) {
        	// route to not an admin page
            return redirect()->route('403');
        }
        return $next($request);
    }
}