<?php
require 'Chapitre 1 – Connexion à une base de données avec PDO.php';

try{
    $stmt= $pdo->prepare('INSERT INTO utilisateur (nom, email) VALUES (:nom, :email);');
    $stmt->execute([
        'nom'=>'David',
        'email'=>'Davidgomez@gmail.com'
    ]);
    echo "L'utilisateur a été ajouté avec succès.";
    }catch(PDOException $e){
    echo "Erreur d'ajout : " . $e->getMessage();
}
try{
    $stmt= $pdo->prepare('UPDATE utilisateur SET email=:email WHERE id=:id');
    $stmt->execute([
        'email'=>"BobElInzano@gmail.com",
        'id'=>1
    ]);
    echo "L'utilisateur a été mis à jour avec succès.";
    }catch(PDOException $e){
    echo "Erreur de mise à jour type: " . $e->getMessage();
}
try{

    $stmt= $pdo->prepare('DELETE FROM utilisateur WHERE id=:id');
    $stmt->execute(['id'=>2]);
    echo "L'utilisateur a été supprimé avec succès.";
}catch(PDOException $e){
    echo "Erreur de suppression type: " . $e->getMessage();
}

echo $stmt->rowCount() . " ligne(s) affectée(s).";
?>