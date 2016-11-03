<?php

namespace ConsoleTVs\Links\Middleware;

use Crypt;
use Closure;

class LinksMiddleware
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! session('links.password') || (Crypt::decrypt(session('links.password')) != config('links.password'))) {
            return redirect()
                ->route('links::login')
                ->with('msg', 'Your login has expired or does not exist.');
        }

        return $next($request);
    }
}
