<?php
session_start();


// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

// Vérification de la session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Récupération des données POST
$id = $_POST["produit"];
$identifiant = $_POST["id_compte"];
$mdp = $_POST["mdp_compte"];

// Ajout des quotes pour éviter les erreurs SQL
$req = "INSERT INTO comptes (identifiant_compte, password_compte, id_produit) VALUES ('$identifiant', '$mdp', $id)";
$bdd->query($req);

// Redirection
header('Location: ../vue/manageproduits.php');
exit();

?>
