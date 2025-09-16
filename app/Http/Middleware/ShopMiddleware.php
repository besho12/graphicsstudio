<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\GlobalSetting\app\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class ShopMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        {
            $shop = cache()->get('setting')?->is_shop ?? Setting::where('key', 'is_shop')->value('value');
            if ($shop) {
                return $next($request);
            }
            abort(404);
        }
    }
}
