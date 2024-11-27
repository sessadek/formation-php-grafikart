<?php

namespace App\Validator;

use Valitron\Validator as ValitronValidator;

abstract class Validator {

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected array $data;

    /**
     * Undocumented variable
     *
     * @var Valitron\Validator
     */
    protected $validator;

    /**
     * Undocumented function
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validator = new ValitronValidator($data);
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function validate(): bool
    {
        return $this->validator->validate();
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->validator->errors();
    }
}