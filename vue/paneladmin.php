<?php
session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$site_name = "Cheap";
$current_year = date('Y');

// Vérification du statut administrateur
if (!isset($_SESSION['user_id']) || !isset($_SESSION['type_user']) || $_SESSION['type_user'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
try {
    $bdd = pdo();
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_name ?> - ADMIN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f9f9f9;
        }
        h1 {
            color: #FF5A5F;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin: 10px 0;
        }
        a {
            color: #FF5A5F;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>👋 Hello Admin</h1>
    <p>Bienvenue sur le panneau d'administration de <strong><?= $site_name ?></strong>.</p>
    <p>Vous pouvez gérer les utilisateurs, les abonnements et les contenus depuis cette interface.</p>
    
    <ul>
        <li><a href="manageusers.php">👤 Gérer les utilisateurs</a></li>
        <li><a href="manageproduits.php">📦 Gérer les abonnements</a></li>
        <li><a href="managecommandes.php">🧾 Gérer les commandes</a></li>
        <li><a href="dashboard.php">📊 Statistiques</a></li>
        <li><a href="../controller/controllerlogout.php">🚪 Se déconnecter</a></li>
    </ul>
    
</body>
</html>
