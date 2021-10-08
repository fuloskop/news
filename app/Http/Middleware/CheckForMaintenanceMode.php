<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Original;

class CheckForMaintenanceMode extends Original
{

    protected $excludedNames = [];

    protected $except = ['/login','/logout','/maintenance'];

    protected $excludedIPs = [];

    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            $response = $next($request);

            if (in_array($request->ip(), $this->excludedIPs)) {
                return $response;
            }

            $route = $request->route();

            if ($route instanceof Route) {
                if (in_array($route->getName(), $this->excludedNames)) {
                    return $response;
                }
            }

            if($request->is('api/getToken','api/getNews','api/getNewsDetail')){
                return response()->json(['status' => false, 'message' => 'There is maintenance in the application. Please try again later.'], 503, []);
            }

            $isLoginAdmin = false;
            if(auth()->user()){
                $isLoginAdmin = auth()->user()->hasPermissionTo('start stop maintenance');
            }

            if ($this->shouldPassThrough($request) || $isLoginAdmin)
            {
                return $response;
            }

            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}
