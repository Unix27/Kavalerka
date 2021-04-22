<?php

namespace Shop\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool|mixed url
 * @property mixed product_id
 * @mixin \Eloquent
 */
class Video extends Model
{
    protected $table = 'shop_videos';
    public $fillable = ['link','product_id'];

    function getYouTubeVideoId() {
        $link = $this->link;
        $video_id = explode("?v=", $link);
        if (!isset($video_id[1])) {
            $video_id = explode("youtu.be/", $link);
        }
        $youtubeID = $video_id[1];
        if (empty($video_id[1])) $video_id = explode("/v/", $link);
        $video_id = explode("&", $video_id[1]);
        $youtubeVideoID = $video_id[0];
        if ($youtubeVideoID) {
            return $youtubeVideoID;
        } else {
            return false;
        }
    }
}
