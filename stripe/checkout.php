<?php
// Solution temporaire en attendant l'installation de Composer
if (!file_exists('../vendor/autoload.php')) {
    // Vérifier si le dossier vendor existe, sinon le créer
    if (!is_dir('../vendor')) {
        mkdir('../vendor', 0777, true);
    }
    
    // Message d'instructions
    echo "Veuillez suivre ces étapes pour installer les dépendances :<br>";
    echo "1. Téléchargez Composer depuis https://getcomposer.org/download/<br>";
    echo "2. Installez Composer<br>";
    echo "3. Ouvrez un terminal dans le dossier C:/xampp/htdocs/Cheap<br>";
    echo "4. Exécutez la commande : composer install<br>";
    exit();
}

require '../vendor/autoload.php';

// Chargement des variables d'environnement
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configuration de Stripe avec la clé depuis .env
\Stripe\Stripe::setApiKey($_ENV['STRIPE_API_KEY']);

session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../vue/login.php");
    exit();
}

// Vérifie si un produit a été envoyé
if (!isset($_POST['id_produit'])) {
    echo "Produit non spécifié.";
    exit();
}

$id_produit = intval($_POST['id_produit']);

// Connexion à la base avec les variables d'environnement
try {
    $bdd = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8',
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
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

    // Redirection vers Stripe
    header("Location: " . $checkout_session->url);
    exit();
} catch (Exception $e) {
    error_log("Erreur Stripe : " . $e->getMessage());
    echo "Une erreur est survenue lors de la création de la session de paiement. Veuillez réessayer.";
    exit();
}
?>