<?php

try{
$PDO= new PDO('mysql:host=localhost;dbname=blogdb','root','Bl4z3.00');
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie";
}catch (PDOException $e) {
    file_put_contents('erreurs.log', $e->getMessage(), FILE_APPEND);
    echo "Erreur de connexion" . "<br>";
}
try{
    $PDO->query("SELECT * FROM article");
}catch (PDOException $e) {
    file_put_contents('erreurs.log', $e->getMessage(), FILE_APPEND);
    echo "Erreur SQL";
}
?>