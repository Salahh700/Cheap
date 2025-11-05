<?php   
session_start();
$username = $_POST['username'];
$mail = $_POST['email'];
$pass = $_POST['password']; 

// Connexion à la BDD
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

// Vérifier si l'email existe déjà
$requete = "SELECT * FROM users WHERE mail_user = ?";
$stmt = $bdd->prepare($requete);
$stmt->execute([$mail]);
$res = $stmt->fetch();

if ($res) {
    echo "Erreur : Cet email est déjà utilisé.";
    echo "<p><a href='../vue/signup.php'>Retour à la page d'inscription</a></p>";
    exit();

} else {
    
    // Validation de l'email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "Format d'email invalide.";
        echo "<p><a href='../vue/signup.php'>Retour à la page d'inscription</a></p>";
        exit();
    }

    // Validation de la force du mot de passe
    if (strlen($pass) < 8) {
        echo "Le mot de passe doit contenir au moins 8 caractères.";
        echo "<p><a href='../vue/signup.php'>Retour à la page d'inscription</a></p>";
        exit();
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insertion avec sécurité
    $requete = "INSERT INTO users (username_user, mail_user, password_user) VALUES (?, ?, ?)";
    $stmt = $bdd->prepare($requete);
    $stmt->execute([$username, $mail, $hashed_password]);

    // Passage des variables dans la session
    $_SESSION['user_id'] = $bdd->lastInsertId();
    $_SESSION['username'] = $username;
    $_SESSION['email_user'] = $mail;


    header('Location: ../vue/home.php');
    exit();
}
?>
