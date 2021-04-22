<?php


namespace Admin\Http\Middleware;

use Gate;
use Auth;
use Closure;
use Illuminate\Support\Carbon;
use Localization;
use Session;


class AdminMiddleware
{
    public function handle($request, Closure $next, $guard = 'admin')
    {
        /*if (! Auth::guard($guard)->check()) {
            return response()->json('', 403);
        }*/

        $this->setLocaleSession();

        return $next($request);
    }

    protected function setLocaleSession()
    {

        $locale = request()->header('locale') ?? \Localization::getDefaultLocale();

        app()->setLocale($locale);

        Carbon::setLocale($locale);
        Localization::setLocale($locale);
    }
}
