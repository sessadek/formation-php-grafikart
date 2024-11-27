<?php

use DateTime;
use DateTimeZone;

class Message {

    public $username;
    public $message;
    private $date;
    public $errors = [];

    public function __construct($username, $message, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new DateTime();
    }

    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    public function getErrors(): array
    {
        if(!empty($this->username) && strlen($this->username) < 3) {
            $this->errors["username"] = 'Merci de saisir un username plus que 3 caractere';
        }
        if(!empty($this->message) && strlen($this->message) < 10) {
            $this->errors["message"] = 'Merci de saisir un message plus que 10 caractere';
        }
        return $this->errors;
    }

    public function toHTML(): string {
        $username = htmlentities($this->username);
        $message = nl2br(htmlentities($this->message));
        $this->date->setTimezone(new DateTimeZone("Africa/Casablanca"));
        $date = $this->date->format('d/m/Y à H\hi');
        return "<p><strong>{$username}</strong> <em>le {$date}</em><br>{$message}</p>";
    }


    public function toJSON(): string {
        return json_encode([
            'username' => $this->username,
            'message' => $this->username,
            'date' => $this->date->getTimestamp()
        ]);
    }

    public static function fromJSON(string $json): Message {
        $data = json_decode($json, true);
        $date = new DateTime("@".$data['date']);
        return new self($data['username'], $data['message'], $date);
    }

}