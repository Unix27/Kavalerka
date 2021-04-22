<?php


namespace Core\EditorJs;


use EditorJS\EditorJS;
use EditorJS\EditorJSException;

class HtmlConverter
{
    public static function getHtml($content)
    {
        $result = '';

        $config = file_get_contents(__DIR__ . '/config.json');

        try {
            $editorJs = new EditorJS(json_encode($content), $config);
        } catch (EditorJSException $e) {
            dd($e);
        }

        $blocks = json_decode(json_encode($content), true)['blocks'];

        foreach ($blocks as $block) {
            if ($block['type'] == 'paragraph') {

                $text = self::addNofollow($block['data']['text']);

                $result .= "<p>" . $text . "</p>";
            }

            elseif ($block['type'] == 'image') {

                $src = $block['data']['file']['url'];
                $alt = $block['data']['alt'];
                $title = $block['data']['title'];

                $class = 'image';

                $result .= "<div class='$class'>" .
                    "<img src='$src' alt='$alt' title='$title'/>" .
                    "</div>";

            } elseif ($block['type'] == 'list') {
                if ($block['data']['style'] == 'unordered') {
                    $result .= '<ul>';

                    foreach ($block['data']['items'] as $listItem) {
                        $listItem = self::addNofollow($listItem);
                        $result .= "<li>$listItem</li>";
                    }

                    $result .= '</ul>';
                } else {
                    $result .= '<ol>';

                    foreach ($block['data']['items'] as $listItem) {
                        $listItem = self::addNofollow($listItem);
                        $result .= "<li>$listItem</li>";
                    }

                    $result .= '</ol>';
                }
            } elseif ($block['type'] == 'header') {

                $level = $block['data']['level'];
                $text = $block['data']['text'];

                $result .= "<h$level>$text</h$level>";
            } elseif ($block['type'] == 'raw') {
                $result .= $block['data']['html'];
            } elseif ($block['type'] == 'quote') {
                $result .= "<blockquote>";
                $result .= "<header>";
                $result .= $block['data']['caption'];
                $result .= "</header>";
                $result .= "<p>";
                $result .= $block['data']['text'];
                $result .= "</p>";
                $result .= "</blockquote>";
            } else {
                dd($block);
            }
        }

        return $result;
    }

    protected static function addNofollow($content)
    {

        $content = preg_replace_callback('/]*href=["|\']([^"|\']*)["|\'][^>]*>([^<]*)<\/a>/i', function ($m) {
            if (strpos($m[1], url('')) === false)
                return 'href="' . $m[1] . '" rel="nofollow" target="_blank">' . $m[2] . '</a>';
            else
                return 'href="' . $m[1] . '">' . $m[2] . '</a>';
        }, $content);
        return $content;

    }
}
