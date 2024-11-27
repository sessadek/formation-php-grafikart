<?php

namespace App;

class URLHelper {

    public static function withParam(string $param, $value, array $data): string
    {
        $value = is_array($value) ? implode(",", $value) : $value;
        return http_build_query(array_merge($data, [$param => $value]));
    }

    public static function withParams(array $data, array $params): string
    {
        $params = array_map(function ($v) {
            return is_array($v) ? implode(',', $v) : $v;
        }, $params);
        return http_build_query(array_merge($data, $params));
    }
}