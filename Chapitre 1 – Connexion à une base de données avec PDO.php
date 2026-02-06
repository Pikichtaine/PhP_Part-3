<?php
$servidor='localhost';
$database='blogdb';
$password='Bl4z3.00';
$user='root';

try{
$pdo= new PDO("mysql:host=$servidor;dbname=$database;charset=utf8",$user,$password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "connexion réussie";
}catch (PDOException $e){
    echo "error de connexion type: " . $e->getMessage();
}
?>