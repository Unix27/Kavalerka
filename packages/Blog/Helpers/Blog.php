<?php


namespace Blog\Helpers;

use Blog\Models\BlogPost;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Image;
use Storage;

class Blog
{


    public function getPostImage($width, $height, $filename)
    {

        try {
            $imagePath = Storage::get(config('blog.image_folder') . '/' . $filename);
        } catch (FileNotFoundException $e) {
            abort(404);
        }

        $cacheImage = Image::cache(function($image) use ($imagePath, $width, $height) {

            /**
             * @var Image $image
             */

            return $image->make($imagePath)->fit($width, $height);

        }, null);

        return $cacheImage;
    }

    public function getImageUrl($width, $height, $path)
    {
        if(empty($path))
            return asset('images/placeholder-image.png');

        return route('blog.post.image', [$width, $height, $path]);
    }
}
