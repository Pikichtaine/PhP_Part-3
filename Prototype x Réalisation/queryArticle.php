<?php

$id=$_SESSION['id'];

require 'database.php';

try{
$sql= 'SELECT * from article WHERE id_utilisateur=:id
ORDER BY date_pub desc;';
$stlt= $pdo->prepare($sql);
$stlt->execute([
    ':id'=>$id
]);
$cards= $stlt->fetchAll(PDO::FETCH_ASSOC);

}catch(PDOException $e){
    echo "Erreur type: " . $e->getMessage();
}


?>