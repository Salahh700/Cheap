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

use \Mailjet\Resources;
require '../vendor/autoload.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté.";
    exit();
}

if (!isset($_GET['id_produit'])) {
    echo "Produit non spécifié.";
    exit();
}

$id_user = $_SESSION['user_id'];
$Email = $_SESSION['email_user'];
$id_produit = $_GET['id_produit'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifie stock dispo
$checkStock = $bdd->prepare("SELECT stock_produit FROM produits WHERE id_produit = :id");
$checkStock->execute(['id' => $id_produit]);
$stock = $checkStock->fetchColumn();

if (!$stock || $stock <= 0) {
    echo "Ce produit est en rupture de stock.";
    exit();
}

// Récupère un compte dispo
$getCompte = $bdd->prepare("SELECT * FROM comptes WHERE id_produit = :id_produit AND statut_compte = 'disponible' LIMIT 1");
$getCompte->execute(['id_produit' => $id_produit]);
$compte = $getCompte->fetch(PDO::FETCH_ASSOC);

$getProduit = $bdd->prepare("SELECT * FROM produits WHERE id_produit = $compte[id_produit]");
$getProduit->execute();
$produit = $getProduit->fetch(PDO::FETCH_ASSOC);



if (!$compte) {
    echo "Aucun compte disponible pour ce produit.";
    exit();
}

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

// Envoie du mail
$mj = new \Mailjet\Client('688184a5710c1b090968bd1bf4e3a994', '35f46285111187584ecf66e84be24804', true, ['version' => 'v3.1']);

$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "salaharroum93@gmail.com",
                'Name' => "Cheap"
            ],
            'To' => [
                [
                    'Email' => $Email,
                    'Name' => "Utilisateur Cheap"
                ]
            ],
            'Subject' => "🧾 Vos identifiants de commande Cheap",
            'HTMLPart' => "
                <h3>Merci pour votre commande sur Cheap !</h3>
                <p><strong>Produit :</strong> {$produit['nom_produit']}</p>
                <p><strong>Identifiant :</strong> {$compte['identifiant_compte']}</p>
                <p><strong>Mot de passe :</strong> {$compte['password_compte']}</p>
                <p><em>Date :</em> " . date('d/m/Y H:i') . "</p>
            "
        ]
    ]
];

$response = $mj->post(Resources::$Email, ['body' => $body]);

if (!$response->success()) {
    error_log("Erreur Mailjet : " . $response->getStatus() . " - " . $response->getReasonPhrase());
}

// Redirige vers confirmation
header("Location: ../vue/confirmationcommande.php?id_commande=" . $lastId);
exit();
