<?php

session_start();
$site_name = "Cheap";
$current_year = date('Y');
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
//Suppression de l'abonnement
if (isset($_GET['id_produit'])) {
    $id_produit = $_GET['id_produit'];

    // Préparation de la requête de suppression
    $requete = "DELETE FROM produits WHERE id_produit = ?";
    $stmt = $bdd->prepare($requete);
    
    // Exécution de la requête
    if ($stmt->execute([$id_produit])) {
        // Redirection vers la page de gestion des produits après la suppression
        header('Location: ../vue/manageproduits.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de l'abonnement.";
    }
} else {
    echo "Aucun identifiant d'abonnement fourni.";
}

?>