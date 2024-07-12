<?php

declare(strict_types=1);

require_once './config/DataBaseManager.php';
require_once './models/Post.php';
require_once './models/ApiKey.php';

class ControllerKey {
    private $dbManager;

    public function __construct() 
    {
        $this->dbManager = new DatabaseManager();
    }

    public function generate($length = 64) {
        $apiKey = bin2hex(random_bytes($length / 2));
        echo $apiKey;
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

    public function connectApi(string $apiKey): bool 
    {
        return $this->getConnectApi($apiKey);
    }

    private function getConnectApi($apiKey): bool
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $query = 'SELECT id FROM users WHERE api_key = :apiKey';
            $result = $bdd->prepare($query);
            $result->execute(['apiKey' => $apiKey]);
            $userId = $result->fetchColumn();
           
            return $userId !== false;

        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        }
    }

    public function connectUser()
    {
        return $this->getConnectUser();
    }

    private function getConnectUser()
    {
        try {
            $bdd = $this->dbManager->getConnection();

            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
            
                $query = 'SELECT * FROM users WHERE username = :username';
                $result = $bdd->prepare($query);
                $result->bindParam(':username', $username, PDO::PARAM_STR);
                $result->execute();
                $user = $result->fetch(PDO::FETCH_ASSOC);
                
                if ($user && password_verify($password, $user['password'])) {
                    $apiKey = new ApiKey(
                        $user['id'],
                        $user['username'],
                        $user['password'],
                        $user['api_key'],
                        $user['created_at']
                    );
                    $apiKey = $this->json($apiKey);
                    print_r($apiKey);
                    
                } else {
                    echo 'Invalid username or password';
                }
            } else {
                echo 'Username and password are required';
            }

        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        }
    }
}

