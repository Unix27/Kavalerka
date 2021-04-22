<?php


namespace Core\EditorJs;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use Str;

class ImageController extends Controller
{
    protected $folder = "uploads/temp";

    public function __construct()
    {

    }

    public function upload(Request $request)
    {
        $image = $request->file('image');

        $fileName = Str::random(16) . '.' . $image->getClientOriginalExtension();

        $path = Storage::putFileAs($this->folder, $image, $fileName);

        if ($path) {
            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => url(Storage::url($path))
                ]
            ], 200);
        } else {
            return response()->json(null, 400);
        }
    }

    public function fetch(Request $request)
    {
        $url = $request->input('url');

        if (Str::contains($url, 'base64')) {

            $path = $this->folder . '/' . Str::random(16) . '.jpg';

            $image = Image::make($url)->encode('jpg', 80);;

            Storage::put($path, $image);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => url(Storage::url($path))
                ]
            ], 200);
        }
    }
}
