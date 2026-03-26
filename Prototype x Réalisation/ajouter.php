<?php


/* =========================
   VERIFICAR SESIÓN
   ========================= */

session_start();
require 'database.php';

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ajouter</title>
<link rel="stylesheet" href="CSS/ajouter.css">
</head>

<body>



<!-- ========================================
                    HEADER
======================================== -->

<header class="top-bar">
    <img class="logo" src="medias/Solicode.blog.png" alt="Logo">

    <div class="icons">

    <a href="accueil.php">
    <img src="medias/home off.png">
    </a>
    
<div></div>

    <a href="profil.php">
    <img src="medias/user off.png">
    </a>

    </div>

    <div></div>

    </header>


<?php



   if($_SERVER['REQUEST_METHOD'] == "POST") {

    if(isset($_POST['titulo'], $_POST['mensaje'])) {

        $titre = trim($_POST['titulo']);
        $descripcion = trim($_POST['mensaje']);

        if(empty($titre) || empty($descripcion)) {
            die("Todos los campos son obligatorios");
        }



/* =========================
   VERIFICAR LA FOTO
   ========================= */

if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

            $nombre = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];

            $carpeta = "imagenes/";
            $ruta = $carpeta . uniqid() . "_" . $nombre;

            if(!is_dir($carpeta)) {
                mkdir($carpeta, 0755, true);
            }
        

            if(move_uploaded_file($tmp, $ruta)) {

                try {

                    $sqlFoto = "INSERT INTO article (titre, descripcion, photo_path, id_utilisateur) 
                                VALUES (:titre, :descripcion, :photo_path, :id_utilisateur)";

                    $stmt = $pdo->prepare($sqlFoto);

                    $stmt->bindParam(':titre', $titre);
                    $stmt->bindParam(':descripcion', $descripcion);
                    $stmt->bindParam(':photo_path', $ruta);
                    $stmt->bindParam(':id_utilisateur', $_SESSION['id']);

                    $stmt->execute();

                    echo "✅ Imagen subida correctamente";
                header("Location: profil.php");
                exit;
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

            } else {
                echo "❌ Error al subir imagen";
            }

        } else {
            echo "Debes seleccionar una imagen";
        }
    }
}
?>


<!-- ========================================
            FORMULARIO TIPO ARCHIVO
======================================== -->
<form action="" method="POST" enctype="multipart/form-data">

<!-- MAIN CONTENT -->
<div class="main">

    <!-- LEFT CARD -->
    <div class="meme-card">
        <div class="meme-image oculto" id="imajen">
            <img id="preview" src="" alt="meme">
        </div>
        
            <input type="file" id="fileInput" name="foto" required hidden>
            <label for="fileInput" class="upload-box" id="mas">
            </label>
        

        <button class="change-btn oculto" id="deleteBtn">↻ Supprimer l'image</button>
    </div>

    <!-- RIGHT -->
    <div class="panel">
        <div>
            <h3>Escribe un Titulo</h3>
            <input type="text" name="titulo" placeholder="Titulo...">
        </div>
        <div>
            <h3>Escribe una Descripción</h3>
        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu descripcion aquí..."></textarea>
        </div>
        <button type="submit" class="finish-btn">¡HE TERMINADO!</button>
    </div>

</div>

</form>

</body>

<script>

const fileInput = document.getElementById("fileInput");
const deleteBtn = document.getElementById("deleteBtn");
const plusBtn = document.getElementById("mas");
const imajen = document.getElementById("imajen");
const preview = document.getElementById("preview");



/* =========================
   DETECTAR EL CAMBIO DEL INPUT
   ========================= */

fileInput.addEventListener("change", function () {

    if (this.files && this.files[0]) { // si esta lleno, y si existe el primer archivo

        const reader = new FileReader(); // crear objeto fileReader

        reader.onload = function (e) {
            preview.src = e.target.result; // 🔥 aquí se muestra la imagen
        }

        reader.readAsDataURL(this.files[0]); // transforma la foto el un texto de base64

        deleteBtn.style.display = "inline-block";
        plusBtn.style.display = "none";
        imajen.style.display = "inline-block";
    }
});

deleteBtn.addEventListener("click", function (e) {
    e.preventDefault();

    fileInput.value = "";
    preview.src = "";
    deleteBtn.style.display = "none";
    plusBtn.style.display = "inline-block";
    imajen.style.display = "none";
});

</script>

</html>