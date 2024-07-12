<?php
require_once 'Model/Article.php';
require_once 'DataBaseManager.php';

class ArticleController {
    private $dbManager;

    public function __construct() 
    {
        $this->dbManager = new DatabaseManager();
    }

    public function index() 
    {
        $articles = $this->getArticles();
        require 'View/articles/index.php';
    }

    private function getArticles($id = null) {
        try {
            $bdd = $this->dbManager->getConnection();
            $query = 'SELECT article.id, article.title, article.description, article.publish_date, article.url, GROUP_CONCAT(authors.name SEPARATOR ", ") AS author_names
                    FROM article
                    JOIN article_authors ON article.id = article_authors.article_id
                    JOIN authors ON article_authors.author_id = authors.id
                    GROUP BY article.id';

            $result = $bdd->prepare($query);
            $result->execute();
            $rawArticles = $result->fetchAll(PDO::FETCH_ASSOC);
            
            $articles = [];
            foreach ($rawArticles as $rawArticle) {$articles[] = new Article(
                $rawArticle['id'],
                $rawArticle['title'], 
                $rawArticle['description'],
                (new DateTime($rawArticle['publish_date']))->format('d-m-Y'),
                $rawArticle['author_names'],
                $rawArticle['url']
            );
            }

            return $articles;
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return [];
        }
    }
    public function show($id)
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $query = 'SELECT article.id, article.title, article.description, article.publish_date, article.url,
                GROUP_CONCAT(authors.name SEPARATOR ", ") AS author_names,
                GROUP_CONCAT(authors.id SEPARATOR ",") AS author_ids
                FROM article
                LEFT JOIN article_authors ON article.id = article_authors.article_id
                LEFT JOIN authors ON article_authors.author_id = authors.id
                WHERE article.id = :id
                GROUP BY article.id';
            $result = $bdd->prepare($query);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->execute(['id' => $id]);
            $rawArticle = $result->fetch(PDO::FETCH_ASSOC);
            //print_r($rawArticles);
            
            if ($rawArticle) {
                $article = new Article($rawArticle['id'], $rawArticle['title'], $rawArticle['description'], $rawArticle['publish_date'], $rawArticle['author_names'], $rawArticle['url']);

                // previous article            
                $query = 'SELECT * FROM article WHERE id < :id ORDER BY id DESC LIMIT 1';
                $stmt = $bdd->prepare($query);
                $stmt->execute(['id' => $id]);
                $prevArticle = $stmt->fetch(PDO::FETCH_ASSOC);

                // next article
                $query = 'SELECT * FROM article WHERE id > :id ORDER BY id ASC LIMIT 1';
                $stmt = $bdd->prepare($query);
                $stmt->execute(['id' => $id]);
                $nextArticle = $stmt->fetch(PDO::FETCH_ASSOC);

                require 'View/articles/show.php';
            } else {
                echo $id;
                echo "Article not found.";
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        }
    }

    public function author(int $author_id)
    {
        try {
            $bdd = $this->dbManager->getConnection();
            //$author_id = 2;
        
            $query = 'SELECT authors.name AS author_name, article.id, article.title, article.description, article.publish_date
            FROM article
            INNER JOIN article_authors ON article.id = article_authors.article_id
            INNER JOIN authors ON article_authors.author_id = authors.id
            WHERE authors.id = :author_id';
        
            $result = $bdd->prepare($query);
            $result->bindParam(':author_id', $author_id, PDO::PARAM_INT);
            $result->execute(['author_id' => $author_id]);
        
            $articles = $result->fetchAll(PDO::FETCH_ASSOC);

            require 'View/articles/author.php';

        
        
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        }
        
        
    }
        
}

?>