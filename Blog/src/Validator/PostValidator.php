<?php

namespace App\Validator;


use App\Table\PostTable;

class PostValidator extends Validator {

    /**
     * Undocumented function
     *
     * @param array $data
     * @param PostTable $table
     * @param integer|null $PostID
     */
    public function __construct(array $data, PostTable $table, ?int $PostID = null)
    {
        parent::__construct($data);
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 10, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function($field, $value, $params, $fields) use($table, $PostID) {
            return !$table->exists($field, $value, $PostID);
        }, ['name', 'slug'])->message("Cette value {field} est déjà utilisé !!");
    }
}