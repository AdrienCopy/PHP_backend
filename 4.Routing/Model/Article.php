<?php

declare(strict_types=1);

class Article
{
    public $id;
    public $title;
    public $description;
    public $publishDate;
    public $authorNames;
    public $url;

    public function __construct(int $id, string $title, ?string $description, ?string $publishDate, string $authorNames, string $url)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->publishDate = $publishDate;
        $this->authorNames = $authorNames;
        $this->url = $url;
    }

    public function formatPublishDate($format = 'd-m-Y')
    {
        if ($this->publishDate) {
            $dateTime = new DateTime($this->publishDate);
            return $dateTime->format($format);
        }
        return null;
    }
}