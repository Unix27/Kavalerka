<?php

if (! function_exists('setting')) {
    function setting($key = null, $default = null, $locale = null)
    {
        $settings = app()->make('settings');

        if (is_null($key)) {
            return $settings;
        }

        if (is_array($key)) {
            return $settings->set($key);
        }

        if(!$locale)
            $locale = app()->getLocale();

        return $settings->get($key, value($default), $locale);
    }
}
