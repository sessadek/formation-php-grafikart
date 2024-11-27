<?php

namespace App\Helpers;

class Hydrate {

    public static function persistData($model, array $data, array $fields)
    {
        foreach($fields as $field) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
            $model->$method($data[$field]);
        }
    }
}