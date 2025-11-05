<?php

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
$site_name = "Cheap";
$current_year = date('Y');

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username']) || $_SESSION['type_user'] !== 'admin') {
    header('Location: ../vue/login.php');
    exit();
}

// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom_produit = $_POST['nom_produit'];
    $description_produit = $_POST['description_produit'];
    $prix_produit = $_POST['prix_produit'];

    // Gestion de l'image
    if (isset($_FILES['image_produit']) && $_FILES['image_produit']['error'] === 0) {
        $image_produit = file_get_contents($_FILES['image_produit']['tmp_name']);
    } else {
        $image_produit = null; // si aucune image n’est envoyée
    }

    // Insertion dans la base de données avec image
    $stmt = $bdd->prepare("INSERT INTO produits (nom_produit, description_produit, prix_produit, image_produit) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom_produit, $description_produit, $prix_produit, $image_produit]);

    // Redirection vers la page de gestion des produits
    header('Location: ../vue/manageproduits.php');
    exit();
}
?>
