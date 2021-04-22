<?php


namespace Blog\Facades;


use Illuminate\Support\Facades\Facade;

class Blog extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'blog';
    }
}
