<?php
require 'database.php';



/* =========================
   SI $_SESSION['old'] EXISTE, ENTONCES ORDENAR DE MANERA ASCENDENTE, SINO DESCENDENTE
   ========================= */
$order = ($_SESSION['old']) ? "ASC" : "DESC";



/* =========================
    CONSULTA SQL
   ========================= */
try{

$sql = "SELECT 
    u.nom,
    a.id,
    a.photo_path,
    a.date_pub,
    a.titre,
    a.descripcion,
    c.auteur,
    c.contenu

FROM article a

INNER JOIN utilisateur u 
ON u.id = a.id_utilisateur

LEFT JOIN commentaire c 
ON c.id = (
        SELECT c2.id 
        FROM commentaire c2
        WHERE c2.id_article = a.id
        ORDER BY c2.date_pub DESC
        LIMIT 1
)

ORDER BY a.date_pub $order";

$stlt = $pdo->query($sql);
$cards = $stlt->fetchAll(PDO::FETCH_ASSOC);

}catch(PDOException $e){
    echo "Erreur type: " . $e->getMessage();
}
?>