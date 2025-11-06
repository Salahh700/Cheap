<?php
/**
 * ========================================
 * AFFICHAGE IMAGE PRODUIT
 * ========================================
 * Affiche l'image d'un produit depuis la base de données
 */

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

// Connexion à la base de données
try {
    $bdd = pdo();
} catch (PDOException $e) {
    http_response_code(500);
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $bdd->prepare("SELECT image_produit FROM produits WHERE id_produit = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && $row['image_produit']) {
        header("Content-Type: image/jpeg"); // ou png selon le type
        echo $row['image_produit'];
        exit();
    }
}

http_response_code(404);
echo "Image non trouvée";
?>
