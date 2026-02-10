<?php

require 'Chapitre 1 – Connexion à une base de données avec PDO.php';

try{
    $stmt= $pdo->prepare("INSERT INTO utilisateur (nom,email) VALUES (:nom, :email)");
    $stmt->execute([
        'nom'=> 'Kara',
        'email'=> 'Androide2.0@gmail.com'
    ]);
    echo "Utilisateur ajouté." . "<br>";
}catch (PDOException $e) {
    file_put_contents('erreurs.log', $e->getMessage(), FILE_APPEND);
    echo "Erreur d'ajout";
}
try{

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
$nom= "Jorge";
$email="JorgeGarcia@gmail.com";
$stmt->execute();
}catch (PDOException $e) {
    file_put_contents('erreurs.log', $e->getMessage(), FILE_APPEND);
    echo "Erreur d'ajout version Param" . "<br>";
}

try{
$stmt=$pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email");
$stmt->execute([
    'email'=> "JorgeGarcia@gmail.com"
]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    echo "Nom : " . $user['nom'] . "<br>";
}catch (PDOException $e) {
    file_put_contents('erreurs.log', $e->getMessage(), FILE_APPEND);
    echo "Erreur d'information fetch";
}

try{
$stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE id = ?");
$stmt->execute([1]);
$user2=$stmt->fetch(PDO::FETCH_ASSOC);
    echo "Nom : " . $user2['nom'] . "<br>";
}catch (PDOException $e) {
    file_put_contents('erreurs.log', $e->getMessage(), FILE_APPEND);
    echo "Erreur d'information fetch";
}
?>