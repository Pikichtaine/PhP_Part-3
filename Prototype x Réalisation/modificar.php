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
<title>Modifier</title>
<link rel="stylesheet" href="CSS/ajouter.css">
</head>

<body>



<!-- ========================================
                    HEADER
======================================== -->

    <header class="top-bar">
    <img class="logo"src="media/Qwerty.png" alt="Descripción de la imagen">

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



/* =========================
   VERIFICA SI LOS CAMPOS ESTAN LLENOS
   ========================= */

if($_SERVER['REQUEST_METHOD'] == "POST") {

    if(isset($_POST['titulo'], $_POST['mensaje'])) {

        $titre = trim($_POST['titulo']);
        $descripcion = trim($_POST['mensaje']);

        if(empty($titre) || empty($descripcion)) {
            die("Todos los campos son obligatorios");
        }


        
/* =========================
   SI PULSES EL BOTON BORRAR FOTO...
   ========================= */

if($_POST['enviar']=="1"){
    try {

                    $sqlFoto = "UPDATE article SET titre = ?, descripcion = ? WHERE id = ?";

                    $stmt = $pdo->prepare($sqlFoto);

                    $stmt->execute([$titre, $descripcion, $_SESSION['id_edit']]);

                    echo "✅ Imagen subida correctamente";
                header("Location: profil.php");
                exit;
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
}else{

unlink($_SESSION['foto_edit']);

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

                    $sqlFoto = "UPDATE article SET titre = ?, descripcion = ?, photo_path = ? WHERE id = ?";

                    $stmt = $pdo->prepare($sqlFoto);

                    $stmt->execute([$titre, $descripcion, $ruta, $_SESSION['id_edit']]);

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
}
?>
<form action="" method="POST" enctype="multipart/form-data">
<!-- MAIN CONTENT -->
<div class="main">

    <!-- LEFT -->
    <div class="meme-card">
        <div class="meme-image" id="imajen">
            <img id="preview" src="<?php echo $_SESSION['foto_edit']; ?>" alt="meme">
        </div>
        
            <input type="file" id="fileInput" name="foto" hidden>
            <label for="fileInput" class="upload-box oculto" id="mas">
            </label>
        

        <button class="change-btn" id="deleteBtn">↻ Supprimer l'image</button>
    </div>

    <!-- RIGHT -->
    <div class="panel">
        <div>
            <h3>Escribe un Titulo</h3>
            <input type="text" name="titulo" value="<?php echo $_SESSION['edit_titre']; ?>" placeholder="Titulo...">
        </div>
        <div>
            <h3>Escribe una Descripción</h3>
        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu descripcion aquí..."><?php echo $_SESSION['descripcion_edit']; ?></textarea>
        </div>
        <button type="submit" class="finish-btn" id="enviar" name="enviar" value="1">¡HE TERMINADO!</button>
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
const enviar = document.getElementById("enviar");


fileInput.addEventListener("change", function () {

    if (this.files && this.files[0]) {

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result; // 🔥 aquí se muestra la imagen
        }

        reader.readAsDataURL(this.files[0]);

        deleteBtn.style.display = "inline-block";
        plusBtn.style.display = "none";
        imajen.style.display = "inline-block";
    }
});

deleteBtn.addEventListener("click", function (e) {
    e.preventDefault();
    enviar.value="2";
    fileInput.value = "";
    preview.src = "";
    deleteBtn.style.display = "none";
    plusBtn.style.display = "inline-block";
    imajen.style.display = "none";
});

</script>

</html>