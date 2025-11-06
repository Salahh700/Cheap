<?php
session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$site_name = "Cheap";

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour voir cette page.";
    exit();
}

// Connexion à la base de données
try {
    $bdd = pdo();
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifie que l'ID de la commande est fourni
if (!isset($_GET['id_commande'])) {
    echo "Aucune commande spécifiée.";
    exit();
}

$id_commande = $_GET['id_commande'];
$id_user = $_SESSION['user_id'];

// On vérifie que la commande appartient à l'utilisateur connecté
$sql = "SELECT commandes.id_commande, commandes.date_commande, comptes.identifiant_compte, comptes.password_compte, produits.nom_produit
        FROM commandes
        INNER JOIN comptes ON commandes.id_compte = comptes.id_compte
        INNER JOIN produits ON commandes.id_produit = produits.id_produit
        WHERE commandes.id_commande = :id_commande AND commandes.id_user = :id_user";

$stmt = $bdd->prepare($sql);

$stmt->execute([
    ':id_commande' => (int)$id_commande,
    ':id_user' => (int)$id_user
]);

$commande = $stmt->fetch(PDO::FETCH_ASSOC);




if (!$commande) {
    echo "Commande non trouvée ou vous n'avez pas accès à cette commande.";
    exit();
}
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande - <?= $site_name ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f5f5f5;
            text-align: center;
        }
        .box {
            background: white;
            padding: 2rem;
            max-width: 500px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #FF5A5F;
        }
        p {
            font-size: 1.1rem;
        }
        .credentials {
            margin-top: 1.5rem;
            background: #f2f2f2;
            padding: 1rem;
            border-radius: 8px;
        }
        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #FF5A5F;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>✅ Commande Confirmée !</h1>
    <p>Merci pour votre achat sur <strong><?= $site_name ?></strong>.</p>
    <p>Produit : <strong><?= htmlspecialchars($commande['nom_produit']) ?></strong></p>
    <p>Date de commande : <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></p>

    <div class="credentials">
        <h3>🧾 Vos identifiants :</h3>
        <p><strong>Identifiant :</strong> <?= htmlspecialchars($commande['identifiant_compte']) ?></p>
        <p>Le <strong>Mot de passe </strong> a été envoyé sur votre mail.</p>
        <p>Utilisez ces identifiants pour vous connecter à votre compte.</p>
        <p>Il a également été envoyé sur votre mail.</p>
    </div>

    <a class="button" href="home.php">Retour à l'accueil</a>
</div>

</body>
</html>
