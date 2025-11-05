<?php

session_start();

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

// Vérification de la session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

//requete permettant de supprimer le compte
$id = $_GET['id_compte'];
$req = "DELETE FROM comptes WHERE id_compte = $id";
$bdd->query($req);

// Redirection vers la page de gestion des produits
header('Location: ../vue/manageproduits.php');
exit();

?>