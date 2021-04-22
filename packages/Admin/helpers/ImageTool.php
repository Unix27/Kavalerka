<?php


namespace Admin\helpers;


use Image;
use Storage;

class ImageTool
{
    public function __construct()
    {
    }

    public function saveFromUrl($path, $url)
    {
        $Image = Image::make($url);

        $imagePath = $path . '/' . \Str::random() . '.jpg';

        $Image->save(Storage::path($imagePath));

        return $imagePath;
    }

    public function get($path)
    {
        return Storage::url($path);
    }
}
