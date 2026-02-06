<?php
require 'Chapitre 1 – Connexion à une base de données avec PDO.php';

try{
$sql= 'SELECT * FROM utilisateur';
$strt= $pdo->query($sql);
$utilisateur= $strt->fetchAll(PDO::FETCH_ASSOC);

foreach($utilisateur as $user){
    echo "ID : " . $user['id'] . " - Nom : " . $user['nom'] . " - Email : " . $user['email'] . "<br>";
}

}catch(PDOException $e){
    echo "Erreur type: " . $e->getMessage();
}
?>