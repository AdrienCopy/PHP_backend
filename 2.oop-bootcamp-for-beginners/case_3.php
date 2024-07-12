<?php

class Content {
    protected $title;
    protected $text;

    public function __construct(string $title, string $text)
    {
        $this->title = $title;
        $this->text = $text;
    }

    public function getTitle(): string 
    {
        return $this->title;
    }

    public function getText(): string 
    {
        return $this->text;
    }

    public function display(): void 
    {
        echo "<h2>" . $this->getTitle() . "</h2>";
        echo "<p>" . $this->getText() . "</p>";
    }
}

class Article extends Content {
    public function displayContent(): void 
    {
        echo "<div class='article' style='border: solid;'>";
        parent::display();
        echo "</div><br>";
    }
}

class Ads extends Content {
    public function displayContent(): void 
    {
        echo "<div class='ads' style='border: solid;'>";
        echo "<h2>" . strtoupper($this->getTitle()) . "</h2>";
        echo "<p>" . strtoupper($this->getText()) . "</p>";
        echo "</div><br>";
    }
}

    class Job extends Content {
        public function displayContent(): void 
        {
            echo "<div class='job' style='border: solid;'>";
            echo "<p> - apply now! </p>";
            parent::display();
            echo "</div><br>";
        }
}

class ContentManager {
    private $contents = [];

    public function addContent(Content $content): void {
        $this->contents[] = $content;
    }

    public function displayAllContents(): void {
        foreach ($this->contents as $content) {
            $content->displayContent();
        }
    }

    public function applyToFirstArticle(callable $callback): void {
        foreach ($this->contents as $index => $content) {
            if ($content instanceof Article) {
                $this->contents[$index] = $callback($content);
                break;
            }
        }
    }
}

$article0 = new Article("Article Title", "This is the text of the article.");
$article1 = new Article("New article Title", "This is the new text of the article.");
$ads0 = new Ads("Ads Title", "This is the text of the ADS ...");
$job0 = new Job("Job Title", "This is the text of the vacancies.");

$contentManager = new ContentManager();

$contentManager->addContent($article1);
$contentManager->addContent($article0);
$contentManager->addContent($ads0);
$contentManager->addContent($job0);

/*$contentManager->applyToFirstArticle(function($content) {
    ob_start();
    echo "<div style='border: 2px solid red;'>";
    $content->displayContent();
    echo "</div>";
    $newContent = ob_get_clean();
    return new Article($content->getTitle(), $newContent);
});*/

$contentManager->displayAllContents();