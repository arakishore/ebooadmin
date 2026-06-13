<?php

if (! function_exists('generate_slug')) {

    function generate_slug($text)
    {
        $text = trim($text);
        $text = strtolower($text);
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');

        return $text ?: 'n-a';
    }
}