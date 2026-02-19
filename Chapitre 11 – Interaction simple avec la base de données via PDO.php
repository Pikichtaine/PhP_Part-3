<?php

class Database {
    private $host = "localhost";
    private $db_name = "blogdb";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
        return $this->conn;
    }
}


$db = (new Database())->getConnection();
$stmt = $db->query("SELECT * FROM articles");


$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($articles as $article) {
    echo $article['titre'] . " - " . $article['auteur'] . "<br>";
}

$sql = "INSERT INTO articles (titre, contenu, auteur) VALUES (:titre, :contenu, :auteur)";
$stmt = $db->prepare($sql);
$stmt->execute([
    'titre' => 'Nouveau post',
    'contenu' => 'Ceci est un article ajouté via PDO.',
    'auteur' => 'Admin'
]);

?>