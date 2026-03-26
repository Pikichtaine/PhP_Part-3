<?php

require 'database.php';
try{
$sql= 'SELECT * from commentaire
where id_article=:id
order by date_pub desc
limit 1;';
$stct= $pdo->prepare($sql);
$stct->execute([
    ":id"=>$card['id']
]);
$comment=$stct->fetch(PDO::FETCH_ASSOC);

}catch(PDOException $e){
    echo "Erreur type: " . $e->getMessage();
}


?>