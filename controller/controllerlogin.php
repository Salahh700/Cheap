<?php

session_start();
$site_name = "Cheap";
$current_year = date('Y');

try {
    // Connexion à la base de données avec gestion d'erreurs
    $bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // Vérification que les champs ne sont pas vides
    if(empty($_POST['username']) || empty($_POST['password'])) {
        throw new Exception("Tous les champs sont obligatoires");
    }

    // Récupération des données du formulaire avec nettoyage
    $username = trim(htmlspecialchars($_POST['username']));
    $password = $_POST['password'];

    // Préparation de la requête pour trouver l'utilisateur
    $requete = "SELECT * FROM users WHERE username_user = ? OR mail_user = ?";
    $stmt = $bdd->prepare($requete);
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password_user'])) {
        // Connexion réussie
        session_regenerate_id(true); // Protection contre la fixation de session
        
        // Stockage des informations en session
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username_user'];
        $_SESSION['type_user'] = $user['type_user'];
        $_SESSION['email_user'] = $user['mail_user'];

        // Redirection selon le rôle
        if ($user['type_user'] === 'admin') {
            header('Location: ../vue/paneladmin.php');
        } else {
            header('Location: ../vue/home.php');
        }
        exit();
    } else {
        throw new Exception("Nom d'utilisateur ou mot de passe incorrect.");
    }
} catch(Exception $e) {
    // Gestion des erreurs
    echo "<div style='color: red; margin: 20px;'>";
    echo $e->getMessage();
    echo "</div>";
    echo "<p><a href='../vue/login.php'>Retour à la page de connexion</a></p>";
    exit();
}
?>
