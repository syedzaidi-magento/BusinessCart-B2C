<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetCurrentStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.enable_multi_store')) {
            $subdomain = explode('.', $request->getHost())[0];
            $store = Store::where('name', $subdomain)->firstOrFail();
            App::instance('current_store', $store);
        }
        return $next($request);
    }
}
