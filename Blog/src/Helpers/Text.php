<?php

namespace App\Helpers;

class Text
{

    public static function truncateString(string $string, int $length = 250, string $ellipsis = '...'): string
    {
        if (mb_strlen($string) >= $length) {
            $lastSpace = mb_strpos($string, ' ', $length);
            return mb_substr($string, 0, $lastSpace) . $ellipsis;
        }
        return $string;
    }
}
