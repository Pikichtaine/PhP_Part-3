<?php
session_start();
require "database.php";

$id_article = $_POST['id'];
$contenido = $_POST['contenido'];
$auteur = $_SESSION['utilisateur'];

$sql = "INSERT INTO commentaire (id_article, auteur, contenu, date_pub) VALUES (?, ?, ?, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_article, $auteur, $contenido]);
