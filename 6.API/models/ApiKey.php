<?php

declare(strict_types=1);

class ApiKey
{
    public $id;
    public $username;
    public $password;
    public $api_key;
    public $created_at;

    public function __construct(int $id, string $username, string $password, string $api_key, string $created_at)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->api_key = $api_key;
        $this->created_at = $created_at;
    }

    public function formatPublishDate($format = 'd-m-Y', $dateType = 'created_at')
    {
        if ($this->$dateType) {
            $dateTime = new DateTime($this->$dateType);
            return $dateTime->format($format);
        }
        return null;
    }
}