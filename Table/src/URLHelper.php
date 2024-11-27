<?php

namespace App;

class URLHelper {

    public static function withParam(string $param, $value, array $data): string
    {
        return http_build_query(array_merge($data, [$param => $value]));
    }

    public static function withParams(array $params, array $data): string
    {
        return http_build_query(array_merge($data, $params));
    }
}