<?php
/**
 * ========================================
 * STRIPE CHECKOUT - CORRIGÉ
 * ========================================
 * Gère la création de session de paiement Stripe
 */

session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    redirect('../vue/login.php');
    exit();
}

// Vérifie si un produit a été envoyé
if (!isset($_POST['id_produit'])) {
    echo "Produit non spécifié.";
    exit();
}

$id_produit = intval($_POST['id_produit']);

// Charger Stripe via vendor/autoload si disponible
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die("Erreur : Les dépendances Stripe ne sont pas installées. Veuillez exécuter 'composer install' dans le dossier racine.");
}

require_once __DIR__ . '/../vendor/autoload.php';

// Configuration de Stripe avec la clé depuis .env
\Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));

// Connexion à la base de données via notre système
try {
    $bdd = pdo();
} catch (PDOException $e) {
    logger('Database connection error in checkout: ' . $e->getMessage(), 'error');
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupération des infos produit
$stmt = $bdd->prepare("SELECT * FROM produits WHERE id_produit = :id");
$stmt->execute(['id' => $id_produit]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo "Produit introuvable.";
    exit();
}

try {
    // Construire les URLs de base
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $base_path = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/');
    $base_url = $protocol . "://" . $host . $base_path;

    // Créer la session de paiement Stripe
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $produit['nom_produit'],
                    'description' => $produit['description_produit'] ?? ''
                ],
                'unit_amount' => intval($produit['prix_produit'] * 100) // en centimes
            ],
            'quantity' => 1
        ]],
        'mode' => 'payment',
        'success_url' => $base_url . "/stripe/success.php?session_id={CHECKOUT_SESSION_ID}&id_produit=" . $id_produit,
        'cancel_url' => $base_url . "/vue/home.php",
        'metadata' => [
            'user_id' => $_SESSION['user_id'],
            'id_produit' => $id_produit
        ]
    ]);

    // Logger la création de la session
    logger("Stripe checkout session created for user {$_SESSION['user_id']}, product {$id_produit}", 'info');

    // Redirection vers Stripe
    header("Location: " . $checkout_session->url);
    exit();
} catch (Exception $e) {
    logger("Stripe checkout error: " . $e->getMessage(), 'error');
    echo "Une erreur est survenue lors de la création de la session de paiement. Veuillez réessayer.";
    exit();
}
?>
