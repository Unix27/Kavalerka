<?php


namespace Site\Common\Http\Middleware;


use Closure;
use Str;

class SeoRedirects
{
    public function handle($request, Closure $next)
    {

        $origUrl = request()->getUri();

        $url = $this->removeDoubleSlashes();

        $url = $this->removeExtension($url);

        $url = $this->removeWww($url);

        if($origUrl != $url){
            return redirect($url, 301);
        }


        return $next($request);
    }

    protected function removeDoubleSlashes()
    {
        $path = request()->getPathInfo();
        if (Str::contains($path, '//')) {
            $segments = request()->segments();
            if (!empty($segments))
                $rightUrl = url('/') . '/' . implode('/', request()->segments());
            else $rightUrl = url('');

            return $rightUrl;
        }

        return request()->getUri();
    }

    protected function removeExtension($url)
    {
        $url = str_replace('.html', '', $url);
        $url = str_replace('.php', '', $url);

        return $url;
    }

    protected function removeWww($url)
    {
        $url = str_replace('://www.', '://', $url);

        return $url;
    }
}
