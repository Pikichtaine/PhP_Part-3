<?php


/* =========================
   VERIFICAR SESIÓN
   ========================= */

session_start();

if(!isset($_SESSION['utilisateur'])){
    header('Location: login.php');
    exit;
}


/* =========================
   Si no hay POST filtra los articulos en reciente
   ========================= */
   
if(!isset($_POST['filter'])){
    $filter=1;
    $_SESSION['old']=[];
    $_SESSION['new']=true;    
}


/* =========================
   CONDICION DEL FILTRO
   ========================= */

if($_SERVER['REQUEST_METHOD']=='POST'){
        $filter = $_POST['filter'];
        if($filter == 1){ 
            $_SESSION['old']=[];
            }elseif($filter == 2){
            $_SESSION['old']=true;
            }
} 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="CSS/accueil.css">
</head>
<body>








<!-- ========================================
                    HEADER
======================================== -->

    <header class="top-bar">

        <img class="logo" src="medias/Solicode.blog.png" alt="Logo">

        <nav class="icons">
            <a href="accueil.php"><img src="medias/home on.png" alt="Home"></a>
            <a href="ajouter.php"><img src="medias/add.png" alt="Add"></a>
            <a href="profil.php"><img src="medias/user off.png" alt="Profile"></a>
        </nav>

        <div></div>

    </header>








<!-- ========================================
                ARTICULOS
======================================== -->

<form id="Form" method="post" action="">
    <main class="container">
        <section class="contenedor">


<!-- ========================================
            FOREACH DE ARTICULOS
======================================== -->

            <?php
require 'queryFilter.php';
require 'tiempo.php';

            foreach ($cards as $card) : ?>

        <article class="card">

        <img src= "<?php echo $card['photo_path'] ?>" alt="Card Image">

    <div class="card-content">
        <div class="card-user">
            <div class="profil">
                <img src="medias/profile.png" alt="User Profile">
                <span class="user"><?php echo $card['nom'] ?></span>
            </div>
            <span>.</span> <span><?php echo tiempoTranscurrido($card['date_pub']) ?></span>
        </div>

        <div class="card-text">
            <?php echo $card['titre'] ?>
        </div>

        <div class="card-description">
    <?php echo $card['descripcion'] ?>
    </div>








<!-- ========================================
            TOP COMMENT CONDICION
======================================== -->

    <?php if($card['contenu']) : ?>

<div class="card-TopComment" onclick="mostrar(<?php echo $card['id'] ?>)">
    <p>Top Comment:</p>
    <div class="card-comment">
        <div class="profil">
            <img src="medias/profile.png">
            <span class="user"><?php echo $card['auteur'] ?></span>
        </div>
        <span>:</span>
        <span><?php echo $card['contenu'] ?></span>
    </div>
</div>

<?php else: ?>



<div class="card-TopComment" onclick="mostrar(<?php echo $card['id'] ?>)">
    <p>No comments yet</p>
</div>

<?php endif; ?>

    </div>

</article>

                                                <?php endforeach; ?>

        </section>








<!-- ========================================
                    FILTER
======================================== -->

        <aside class="leaderboard" id="leaderboard">
            <h2>Filter:</h2>
            <div class="opciones">
                <label for="order-select">ORDER BY:</label>
                <div class="select-wrapper" id="select">


<!-- ========================================
                $FILTER = $POST
======================================== -->

                    <?php
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                    $filter = $_POST['filter'];
                    } 
                    ?>

                    <select name="filter" id="order-select">
                        <option value="1"  <?php if($filter == 1){ echo 'selected'; }else{echo ''; } ?>>Lo Mas Recientes</option>
                        <option value="2"  <?php if($filter == 2){ echo 'selected'; }else{echo ''; } ?>>Lo Mas Antiguos</option>
                    </select>
                
                </div>
            </div>

        </aside>

</form> 








<!-- ========================================
                COMENTARIOS
======================================== -->

<aside class="comentarios oculto" id="comentario">

    <div class="flex-comment">
        <h2>Commentaire:</h2>


<!-- ========================================
            FOREACH DE COMENTARIOS
======================================== -->

<div class="scroll-comment" id="scroll">

<?php require 'queryCommentaire.php'; ?>

</div>  
    
                <input type="text" name="comentario" id="input" placeholder="Comment...">

                </div>

        </aside>
    
</main>







   
<script>
    const scroll= document.getElementById('scroll');
    const leaderboard = document.getElementById('leaderboard');
    const comentarios = document.getElementById('comentario');
    const select = document.getElementById('order-select');
    const form = document.getElementById("Form");
    const inputComentario = document.getElementById("input");


    const commentsCache = {};

function mostrar(id){
    
    comentarios.classList.toggle("oculto");
    leaderboard.classList.toggle("oculto");

scroll.innerHTML = "<p>Loading comments...</p>";    



/* =========================
    LEER CACHE
   ========================= */

    if (commentsCache[id]) {
      scroll.innerHTML = commentsCache[id];
      return;
    }



/* =========================
    ENVIAR FORMULARIO TIPO GET
   ========================= */

    fetch(`queryCommentaire.php?id=${id}`)
      .then(response => response.text())
      .then(data => {
        commentsCache[id] = data;
        scroll.innerHTML = data;
      })
      .catch(error => {
        console.error('Error fetching comments:', error);
        scroll.innerHTML = "<p>Error loading comments</p>";
      });
}

inputComentario.addEventListener("keydown", function(e) {
    if(e.key === "Enter") {


    e.preventDefault();
    const contenido = inputComentario.value.trim();
    if (!contenido) return;



/* =========================
    ENVIAR FORMULARIO TIPO POST EL COMENTARIO NUEVO
   ========================= */

    fetch("queryAddCommentaire.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id + "&contenido=" + encodeURIComponent(contenido)
    })
    .then(res => res.text())
    .then(data => {
        if(scroll.textContent == "No comments yet"){
            scroll.innerHTML="";
        }
        // Añadir el nuevo comentario al HTML sin recargar
        scroll.innerHTML= 
        `<div class='commentaire' id='cuadrado'>
        <img src='medias/profile.png' alt='Profil' class='comment-avatar'>
        <div class='comment-content'>
        <span class='comment-author'>
        <b><?php echo htmlspecialchars($_SESSION['utilisateur']) ?> </b>:
        </span>
        <p class='comment-text'>${contenido}
        </p>
        </div>
        </div>` + scroll.innerHTML;
        
        // Limpiar input
        inputComentario.value = "";
})



/* =========================
    ANADIR NUEVO COMENTARIO A CACHE
   ========================= */

    if (commentsCache[id]) {
            commentsCache[id] += `<div class='commentaire' id='cuadrado'>
        <img src='medias/profile.png' alt='Profil' class='comment-avatar'>
        <div class='comment-content'>
        <span class='comment-author'>
        <b><?php echo htmlspecialchars($_SESSION['utilisateur']) ?> </b>:
        </span>
        <p class='comment-text'>${contenido}
        </p>
        </div>
        </div>` ;
        }
      
    }
})
    


    select.addEventListener("change", ()=> {
    form.submit();
    })
</script>
</body>
</html>