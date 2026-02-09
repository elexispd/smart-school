<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->school) {
             if (! $request->user()->school->is_active) {
                 auth()->logout();
                 return redirect()->route('login')->withErrors(['email' => 'Your school is inactive.']);
             }
        }

        return $next($request);
    }
}
