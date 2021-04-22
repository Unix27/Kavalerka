<?php

namespace Admin\helpers;
class Helper
{
    public static function slugify($text)
    {
       return  \Str::slug($text);
    }
}
?>
-
