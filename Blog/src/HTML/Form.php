<?php

namespace App\HTML;

use DateTimeInterface;

/**
 * Undocumented class
 */
class Form {

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $data;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $errors;

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @param array $errors
     */
    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @param string $label
     * @return string
     */
    public function text(string $key, string $label): string {
        $value = $this->getValue($key);
        return <<<HTML
        <div class="form-group">
        <label for="{$key}" class="form-label">{$label}</label>
        <input type="text" class="{$this->getInputClass($key)}" name="{$key}" id="{$key}" value="{$value}" aria-describedby="{$key}Feedback" required>
        {$this->getFeedback($key)}
    </div>
HTML;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @param string $label
     * @return string
     */
    public function textarea(string $key, string $label): string {
        $value = $this->getValue($key);
        return <<<HTML
        <div class="form-group">
        <label for="{$key}" class="form-label">{$label}</label>
        <textarea type="text" class="{$this->getInputClass($key)}" name="{$key}" id="{$key}" aria-describedby="{$key}Feedback" required>{$value}</textarea>
        {$this->getFeedback($key)}
    </div>
HTML;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return string
     */
    private function getInputClass(string $key): string {
        return isset($this->errors[$key]) ? 'form-control is-invalid' : 'form-control';
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return string
     */
    private function getFeedback(string $key): string {
        return $this->hasError($key) ? ('<div id="nameFeedback" class="invalid-feedback">' . implode('<br>', $this->errors[$key]) . '</div>') : '';
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return boolean
     */
    private function hasError (string $key): bool {
        return isset($this->errors[$key]);
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return string|null
     */
    private function getValue (string $key): ?string {
        
        if(is_array($this->data)) {
            $value = $this->data[$key];
            return $this->formatDateToString($value);
        }
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value = $this->data->$method();
        return $this->formatDateToString($value);
    }

    /**
     * Undocumented function
     *
     * @param string|null|DateTimeInterface $value
     * @return string|null
     */
    private function formatDateToString (string|null|DateTimeInterface $value): ?string {
        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }
}