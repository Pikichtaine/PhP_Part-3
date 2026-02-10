

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Simple</title>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
<?php

require 'Chapitre 1 – Connexion à une base de données avec PDO.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom= htmlspecialchars(trim($_POST['nombre']));
    $email= filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
    die("Email inválido");
}
try{
    if(!empty($nom && $email)) {
        
        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, email) VALUES (:nom, :email)");
    $stmt->execute([
        'nom' => $nom,
        'email' => $email
]);

echo "Formulaire soumis avec succès ";
}
        } catch (PDOException $e) {
    file_put_contents('errors.log', $e->getMessage(), FILE_APPEND);
    echo "Ocurrió un error. Contacta al administrador.";
}
    }
    
?>        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nom</label>
                <input type="text" id="nombre" name="nombre" >
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" >
            </div>
            
            <button type="submit">Se connecter</button>
        </form>
        
        
    </div>
    
</body>
</html>


<!-- J'ai déjà fait cela dans MySQL pour filtrer les restrictions de connexion des utilisateurs
 
GRANT SELECT, INSERT, UPDATE, DELETE ON mi_bd.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES; -->



