<?php

namespace App;

use Exception;

class URL
{

    /**
     * Undocumented function
     *
     * @param string $param
     * @param integer|null $default
     * @return integer|null
     */
    public static function getInt(string $param, ?int $default = null): ?int
    {
        if (!isset($_GET[$param])) return $default;

        if ($_GET[$param] === '0') return 0;

        if (!filter_var($_GET[$param], FILTER_VALIDATE_INT)) {
            throw new Exception("Le paramètre '$param' dans l'url n'est pas un entier");
        }

        return (int)$_GET[$param];
    }

    public static function getPositiveInt(string $param, ?int $default = null): ?int
    {
        $param = self::getInt($param, $default);

        if (!is_null($param) && $param <= 0) {
            throw new Exception("Le paramètre '$param' dans l'url n'est pas positive");
        }
        return $param;
    }

    public static function hasRequestUrlPage(int $total, string $param = 'page') {
        $page = self::getPositiveInt($param);
        if($page > $total) {
            throw new Exception("Le page '$page' dans l'url n'existe pas");
        }
    }
}
