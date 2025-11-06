<?php
/**
 * ========================================
 * STRIPE SUCCESS - CORRIGÉ
 * ========================================
 * Gère la confirmation de paiement et l'envoi du compte
 */

session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté.";
    exit();
}

// Vérifier si un produit a été spécifié
if (!isset($_GET['id_produit'])) {
    echo "Produit non spécifié.";
    exit();
}

$id_user = $_SESSION['user_id'];
$Email = $_SESSION['email_user'];
$id_produit = intval($_GET['id_produit']);

// Charger Mailjet via vendor/autoload si disponible
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die("Erreur : Les dépendances Mailjet ne sont pas installées. Veuillez exécuter 'composer install' dans le dossier racine.");
}

require_once __DIR__ . '/../vendor/autoload.php';

use \Mailjet\Resources;

// Connexion à la base de données via notre système
try {
    $bdd = pdo();
} catch (PDOException $e) {
    logger('Database connection error in success: ' . $e->getMessage(), 'error');
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifie stock dispo
$checkStock = $bdd->prepare("SELECT stock_produit FROM produits WHERE id_produit = :id");
$checkStock->execute(['id' => $id_produit]);
$stock = $checkStock->fetchColumn();

if (!$stock || $stock <= 0) {
    echo "Ce produit est en rupture de stock.";
    logger("Product {$id_produit} out of stock for user {$id_user}", 'warning');
    exit();
}

// Récupère un compte dispo
$getCompte = $bdd->prepare("SELECT * FROM comptes WHERE id_produit = :id_produit AND statut_compte = 'disponible' LIMIT 1");
$getCompte->execute(['id_produit' => $id_produit]);
$compte = $getCompte->fetch(PDO::FETCH_ASSOC);

if (!$compte) {
    echo "Aucun compte disponible pour ce produit.";
    logger("No available account for product {$id_produit}, user {$id_user}", 'warning');
    exit();
}

// Récupère les infos produit
$getProduit = $bdd->prepare("SELECT * FROM produits WHERE id_produit = :id_produit");
$getProduit->execute(['id_produit' => $compte['id_produit']]);
$produit = $getProduit->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo "Produit introuvable.";
    exit();
}

try {
    // Crée commande
    $insertCommande = $bdd->prepare("
        INSERT INTO commandes (id_user, id_produit, id_compte, date_commande)
        VALUES (:id_user, :id_produit, :id_compte, NOW())
    ");
    $insertCommande->execute([
        'id_user' => $id_user,
        'id_produit' => $id_produit,
        'id_compte' => $compte['id_compte']
    ]);

    $lastId = $bdd->lastInsertId();

    // Met à jour compte comme utilisé
    $updateCompte = $bdd->prepare("UPDATE comptes SET statut_compte = 'indisponible' WHERE id_compte = :id_compte");
    $updateCompte->execute(['id_compte' => $compte['id_compte']]);

    // Décrémenter le stock
    $updateStock = $bdd->prepare("UPDATE produits SET stock_produit = stock_produit - 1 WHERE id_produit = :id_produit");
    $updateStock->execute(['id_produit' => $id_produit]);

    logger("Order {$lastId} created for user {$id_user}, product {$id_produit}, account {$compte['id_compte']}", 'info');

    // Envoie du mail avec les identifiants via Mailjet
    $mj = new \Mailjet\Client(
        env('MAILJET_API_KEY'),
        env('MAILJET_API_SECRET'),
        true,
        ['version' => 'v3.1']
    );

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => env('MAIL_FROM_ADDRESS', 'salaharroum93@gmail.com'),
                    'Name' => env('MAIL_FROM_NAME', 'Cheap')
                ],
                'To' => [
                    [
                        'Email' => $Email,
                        'Name' => "Utilisateur Cheap"
                    ]
                ],
                'Subject' => "🧾 Vos identifiants de commande Cheap",
                'HTMLPart' => "
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px 10px 0 0; }
                            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
                            .credentials { background: white; padding: 20px; margin: 20px 0; border-left: 4px solid #667eea; border-radius: 5px; }
                            .footer { text-align: center; margin-top: 20px; color: #666; font-size: 0.9em; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>✅ Merci pour votre commande !</h2>
                            </div>
                            <div class='content'>
                                <p>Bonjour,</p>
                                <p>Votre commande a été traitée avec succès. Voici vos identifiants :</p>

                                <div class='credentials'>
                                    <p><strong>🎯 Produit :</strong> {$produit['nom_produit']}</p>
                                    <p><strong>👤 Identifiant :</strong> <code>{$compte['identifiant_compte']}</code></p>
                                    <p><strong>🔑 Mot de passe :</strong> <code>{$compte['password_compte']}</code></p>
                                    <p><strong>📅 Date :</strong> " . date('d/m/Y H:i') . "</p>
                                </div>

                                <p>⚠️ <strong>Important :</strong> Conservez ces identifiants en lieu sûr. Ne les partagez avec personne.</p>
                                <p>Si vous rencontrez un problème avec ce compte, contactez notre support.</p>

                                <div class='footer'>
                                    <p>Merci de votre confiance !</p>
                                    <p>L'équipe Cheap</p>
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>
                "
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);

    if (!$response->success()) {
        logger("Mailjet error: " . $response->getStatus() . " - " . $response->getReasonPhrase(), 'error');
    } else {
        logger("Email sent successfully to {$Email} for order {$lastId}", 'info');
    }

    // Message flash de succès
    set_flash('success', "Votre commande a été traitée avec succès ! Vos identifiants ont été envoyés par email.", 'success');

    // Redirige vers confirmation
    redirect("../vue/confirmationcommande.php?id_commande=" . $lastId);
    exit();

} catch (Exception $e) {
    logger("Error in success.php: " . $e->getMessage(), 'error');
    echo "Une erreur est survenue lors du traitement de votre commande. Veuillez contacter le support.";
    exit();
}
?>
