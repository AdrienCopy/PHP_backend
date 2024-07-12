<?php 
class DatabaseManager
{
    private $bdd;

    public function __construct()
    {
        $this->connectDatabase();
    }

    private function connectDatabase()
    {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=Article;charset=utf8', 'root', 'root');
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
            exit;
        }
    }

    public function getConnection()
    {
        return $this->bdd;
    }
}
