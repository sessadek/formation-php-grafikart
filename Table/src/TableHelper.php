<?php

namespace App;

class TableHelper {

    const SORT_KEY = 'sort';
    const DIR_KEY = 'dir';

    public static function sort(string $sortKey, string $label, array $data)
    {
        $sort = $data[self::SORT_KEY] ?? null;
        $direction = $data[self::DIR_KEY] ?? null;
        $icon = "";
        if($sort === $sortKey) {
            $icon = $direction === 'asc' ? "^" : 'v';
        }
        $array = [
            'sort' => $sortKey,
            'dir' => $direction === 'asc' && $sort === $sortKey ? "desc" : 'asc'
        ];
        $url = URLHelper::withParams($array, $data);
        return <<<HTML
        <a href="?{$url}">$label $icon</a>
HTML;
    }
}