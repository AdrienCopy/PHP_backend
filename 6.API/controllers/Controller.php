<?php

declare(strict_types=1);

require_once './config/DataBaseManager.php';
require_once './models/Post.php';
require_once './models/Response.php';

class Controller {
    private $dbManager;
    private $responseObject;

    public function __construct() 
    {
        $this->dbManager = new DatabaseManager();
        $this->responseObject = new Response();
    }

    private function json($response)
    {
        $jsonPosts = json_encode($response);
            if ($jsonPosts === false) {
                throw new Exception(json_last_error_msg());
            }
            header('Content-Type: application/json');
            return $jsonPosts;
    }

    public function posts($apiKey)
    {
        $controllerKey = new ControllerKey();
        if ($controllerKey->connectApi($apiKey)) {
            $posts = $this->getPosts();
            print_r($posts);
        } else {
            echo $this->json($this->responseObject->Response('401', 'Unauthorized - Invalid API Key'));
        }
    }
    
    private function getPosts()
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $query = 'SELECT * FROM posts';
            $result = $bdd->prepare($query);
            $result->execute();
            $rawPosts = $result->fetchAll(PDO::FETCH_ASSOC);
            
            if ($rawPosts) {
                foreach ($rawPosts as $rawPost) {$posts [] = new Post(
                    $rawPost['id'],
                    $rawPost['title'], 
                    $rawPost['body'],
                    $rawPost['author'],
                    (new DateTime($rawPost['created_at']))->format('d-m-Y'),
                    (new DateTime($rawPost['updated_at']))->format('d-m-Y')
                );
                }
                $response = $this->responseObject->R200($posts);
            } else {
                $response = $this->responseObject->Response('404', 'Post not found');
            }

        return $jsonPosts = $this->json($response);

        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        } catch (Exception $e) {
            echo 'Erreur de conversion en JSON : ' . $e->getMessage();
        }
    }

    public function postId($apiKey, $id)
    {
        $controller = new ControllerKey();
        if ($controller->connectApi($apiKey)) {
            $post = $this->getPost($id);
            print_r($post);
        } else {
            echo $this->json($this->responseObject->Response('401', 'Unauthorized - Invalid API Key'));
        }
    }

    private function getPost($id)
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $query = 'SELECT * FROM posts WHERE id = :id';
            $result = $bdd->prepare($query);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->execute();
            $rawPost = $result->fetch(PDO::FETCH_ASSOC);
            
            if ($rawPost) {
                $post = new Post(
                    $rawPost['id'],
                    $rawPost['title'],
                    $rawPost['body'],
                    $rawPost['author'],
                    (new DateTime($rawPost['created_at']))->format('d-m-Y'),
                    (new DateTime($rawPost['updated_at']))->format('d-m-Y')
                );
                $response = $this->responseObject->R200($post);
            } else {
                $responseObject = new Response();
                $response = $this->responseObject->Response('404', 'Post not found');
            }
            
            return $jsonPosts = $this->json($response);

        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        } catch (Exception $e) {
            echo 'Erreur de conversion en JSON : ' . $e->getMessage();
        }
    }

    public function postsPage($apiKey, $page, $limit)
    {
        $controllerKey = new ControllerKey();
        if ($controllerKey->connectApi($apiKey)) {
            $posts = $this->getPostsPage($page, $limit);
            print_r($posts);
        } else {
            echo $this->json($this->responseObject->Response('401', 'Unauthorized - Invalid API Key'));
        }
    }

    private function getPostsPage($page, $limit)
    {
        try {
            $bdd = $this->dbManager->getConnection();
            
            $offset = ($page - 1) * $limit;

            $query = 'SELECT * FROM posts LIMIT :limit OFFSET :offset';
            $result = $bdd->prepare($query);
            $result->bindParam(':limit', $limit, PDO::PARAM_INT);
            $result->bindParam(':offset', $offset, PDO::PARAM_INT);
            $result->execute();
            
            $rawPosts = $result->fetchAll(PDO::FETCH_ASSOC);
            
            if ($rawPosts) {
                $posts = [];
                foreach ($rawPosts as $rawPost) {
                    $posts[] = new Post(
                        $rawPost['id'],
                        $rawPost['title'], 
                        $rawPost['body'],
                        $rawPost['author'],
                        (new DateTime($rawPost['created_at']))->format('d-m-Y'),
                        (new DateTime($rawPost['updated_at']))->format('d-m-Y')
                    );
                }
                $response = $this->responseObject->R200($posts);
            } else {
                $response = $this->responseObject->Response('404', 'Post not found');
            }

            return $this->json($response);

        } catch (PDOException $e) {
            return $this->json([
                'status' => 500,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 400,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function createPost($apiKey)
    {
        $controller = new ControllerKey();
        if ($controller->connectApi($apiKey)) {
            $post = $this->addNewPost();
            print_r($post);
        } else {
            echo $this->json($this->responseObject->Response('401', 'Unauthorized - Invalid API Key'));
        }
    }

    private function addNewPost()
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $title = $_POST['title'];
            $body = $_POST['body'];
            $author = $_POST['author'];

            $query = 'INSERT INTO posts (title, body, author, created_at, updated_at) 
                      VALUES (:title, :body, :author, NOW(), NOW())';
            $result = $bdd->prepare($query);
            $result->bindParam(':title', $title, PDO::PARAM_STR);
            $result->bindParam(':body', $body, PDO::PARAM_STR);
            $result->bindParam(':author', $author, PDO::PARAM_STR);
            $result->execute();

            $response = $this->responseObject->R200message("Post created successfully");
            
            return $this->json($response);

        } catch (PDOException $e) {
            return $this->json([
                'status' => 500,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 400,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }  

    public function updater($apiKey, $id)
    {
        $controller = new ControllerKey();
        if ($controller->connectApi($apiKey)) {
            $post = $this->updatePost($id);
            print_r($post);
        } else {
            echo $this->json($this->responseObject->Response('401', 'Unauthorized - Invalid API Key'));
        }
    }

    private function updatePost($id)
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $inputJSON = file_get_contents('php://input');
            $_PUT = json_decode($inputJSON, true);
            //var_dump($_PUT);
            $title = $_PUT['title'];
            $body = $_PUT['body'];
            $author = $_PUT['author'];
            
            $query = 'UPDATE posts 
                      SET title = :title, body = :body, author = :author, updated_at = NOW()
                      WHERE id = :id';
            $result = $bdd->prepare($query);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':title', $title, PDO::PARAM_STR);
            $result->bindParam(':body', $body, PDO::PARAM_STR);
            $result->bindParam(':author', $author, PDO::PARAM_STR);
            $result->execute();


            if ($result->rowCount() > 0) {
                $response = $this->responseObject->R200message("Post updated successfully");
            } else {
                $response = $this->responseObject->Response('404', 'Post not found');
            }

            return $this->json($response);

        } catch (PDOException $e) {
            return $this->json([
                'status' => 500,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 400,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete($apiKey, $id)
    {
        $controller = new ControllerKey();
        if ($controller->connectApi($apiKey)) {
            $post = $this->deletePost($id);
            print_r($post);
        } else {
            echo $this->json($this->responseObject->Response('401', 'Unauthorized - Invalid API Key'));
        }
    }

    private function deletePost($id)
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $query = 'DELETE FROM posts where id = :id';
            $result = $bdd->prepare($query);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->execute();

            if ($result->rowCount() > 0) {
                $response = $this->responseObject->R200message("Post deleted successfully");
            } else {
                $response = $this->responseObject->Response('404', 'Post not found');
            }

            return $this->json($response);

        } catch (PDOException $e) {
            return $this->json([
                'status' => 500,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 400,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
       
    }   
}