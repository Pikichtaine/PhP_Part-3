<?php
session_start();

require 'database.php';



/* =========================
   FUNCION BORRAR
   ========================= */

if($_SERVER['REQUEST_METHOD']=="POST"){
if(isset($_POST['borrar']) && !isset($_POST['edit'])) {

    $valorDelBoton=$_POST['borrar'];
try{
$sql='delete from article where id=:id';

$stdt=$pdo->prepare($sql);
$stdt->execute([
    ':id'=> $valorDelBoton
]);

header('Location: profil.php');

}catch(PDOException $e){
    echo "Erreur type: " . $e->getMessage();
}



/* =========================
   FUNCION EDITAR
   ========================= */

}else{
    $valorDelBotonEdit=$_POST['editar'];

try{
$sql= 'SELECT * FROM article where id=:id';
$stft= $pdo->prepare($sql);
$stft->execute([
    ':id'=> $valorDelBotonEdit
]);
$edit= $stft->fetch(PDO::FETCH_ASSOC);

$_SESSION['foto_edit']=$edit['photo_path'];
$_SESSION['edit_titre']=$edit['titre'];
$_SESSION['descripcion_edit']=$edit['descripcion'];
$_SESSION['id_edit']=$edit['id'];


header('Location: modificar.php');


}catch(PDOException $e){
    echo "Erreur type: " . $e->getMessage();
}

}
}
?>