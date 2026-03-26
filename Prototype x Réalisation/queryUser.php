<?php
session_start();
require 'database.php';

if($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_POST['usuarioInput'])) {
        $usuario=trim($_POST['usuarioInput']);
try{
$sql="UPDATE utilisateur SET nom=:nom WHERE id=:id";

$stbt=$pdo->prepare($sql);
$stbt->execute([
    ":nom"=> $usuario,
    ":id"=> $_SESSION['id']
]);
$_SESSION['utilisateur']=$usuario;

header('Location: profil.php');

}catch(PDOException $e){
    echo "Erreur type: " . $e->getMessage();
}
}
}
?>