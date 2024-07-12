<?php

declare(strict_types=1);

class Post 
{
    public $id;
    public $title;
    public $body;
    public $author;
    public $created_at;
    public $updated_at;

    public function __construct(int $id, string $title, string $body, string $author, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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