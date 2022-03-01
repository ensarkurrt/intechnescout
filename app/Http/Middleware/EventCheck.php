<?php

namespace App\Http\Middleware;

use App\Helpers\FRCHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::critical($request->method(), [$request->path()]);

        $ignoreRoutes = ['login', 'logout', 'register', 'password/reset', 'password/email', 'password/reset/{token}', 'password/reset/{token}/{email}', 'save-note', '/'];
        if ($request->method() == 'GET' && FRCHelper::get_event_id() == null && !in_array($request->route(), $ignoreRoutes)) {
            return redirect()->route('save-event');
        } else {
            return $next($request);
        }
    }
}
