<?php

namespace App\Helpers;

class NewsDataHelper
{
    /**
     * @param string $url
     * @return string
     */
    public static function generateHashByUrl(string $url): string
    {
        return sha1($url);
    }
}
