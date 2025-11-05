<?php

//Controller pour reset de mot de passe
session_start();

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

// Récupération des données du formulaire   
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];
$token = $_POST['token'];

// Vérification des mots de passe
if ($new_password !== $confirm_password) {
    echo "Erreur : Les mots de passe ne correspondent pas.";
    echo "<p><a href='../vue/resetpassword.php?token=$token'>Retour à la page de réinitialisation</a></p>";
    exit();
}

// Préparation de la requête
$requete = "SELECT * FROM users WHERE reset_token = ?";
$stmt = $bdd->prepare($requete); 
$stmt->execute([$token]);
$user = $stmt->fetch();

if ($user) {
    // Mise à jour du mot de passe
    $stmt = $bdd->prepare("UPDATE users SET password_user = ?, reset_token = NULL WHERE reset_token = ?");
    $stmt->execute([$new_password, $token]);
    echo "Votre mot de passe a été réinitialisé avec succès.";
    echo "<p><a href='../vue/login.php'>Retour à la page de connexion</a></p>";
    exit();
} else {
    echo "Erreur : Jeton de réinitialisation invalide.";
    echo "<p><a href='../vue/forgetpassword.php'>Retour à la page de mot de passe oublié</a></p>";
    exit();
}

?>