<?php
require "database.php";



/* =========================
    SI SE ENVIO EL FORMULARIO TIPO GET
   ========================= */

$id = $_GET['id'];



/* =========================
    CONSULTA SQL
   ========================= */

$sql = "SELECT auteur, contenu FROM commentaire
WHERE id_article = ?
ORDER BY date_pub DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);



/* =========================
    CREACION DEL HTML
   ========================= */

if ($comments) {
    foreach ($comments as $comment) {
        echo "<div class='commentaire' id='cuadrado'>";
        echo "<img src='medias/profile.png' alt='Profil' class='comment-avatar'>";
        echo "<div class='comment-content'>";
        echo "<span class='comment-author'>";
        echo "<b>" . htmlspecialchars($comment['auteur']) . "</b>: ";
        echo "</span>";
        echo "<p class='comment-text'>";
        echo htmlspecialchars($comment['contenu']);
        echo "</p>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No comments yet</p>";
}