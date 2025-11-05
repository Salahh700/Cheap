<?php

use \Mailjet\Resources;
require '../vendor/autoload.php'; // adapte le chemin si ton script est dans un sous-dossier

session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour passer une commande.";
    exit();
}

if (!isset($_GET['id_produit'])) {
    echo "Aucun produit sélectionné.";
    exit();
}

$id_produit = $_GET['id_produit'];
$id_user = $_SESSION['user_id'];

// Vérification stock produit
$checkStock = $bdd->prepare("SELECT stock_produit FROM produits WHERE id_produit = :id");
$checkStock->execute(['id' => $id_produit]);
$stock = $checkStock->fetchColumn();

if (!$stock || $stock <= 0) {
    echo "Ce produit est en rupture de stock.";
    exit();
}

// Récupérer compte disponible
$getCompte = $bdd->prepare("SELECT * FROM comptes WHERE id_produit = :id_produit AND statut_compte = 'disponible' LIMIT 1");
$getCompte->execute(['id_produit' => $id_produit]);
$compte = $getCompte->fetch(PDO::FETCH_ASSOC);

if (!$compte) {
    echo "Aucun compte disponible pour ce produit.";
    exit();
}

// Debug : vérifier variables avant insertion
var_dump($id_user, $id_produit, $compte['id_compte']);

try {
    // Insertion commande
    $insertCommande = $bdd->prepare("
        INSERT INTO commandes (id_user, id_produit, id_compte, date_commande)
        VALUES (:id_user, :id_produit, :id_compte, NOW())
    ");

    $insertCommande->execute([
        'id_user' => $id_user,
        'id_produit' => $id_produit,
        'id_compte' => $compte['id_compte']
    ]);

    // Récupérer dernier ID inséré
    $lastId = $bdd->lastInsertId();
    var_dump($lastId);

    if ($lastId == 0) {
        throw new Exception("L'ID de la dernière insertion est 0, ce qui n'est pas normal.");
    }

    // Mise à jour compte indisponible
    $updateCompte = $bdd->prepare("UPDATE comptes SET statut_compte = 'indisponible' WHERE id_compte = :id_compte");
    $updateCompte->execute(['id_compte' => $compte['id_compte']]);

    //Envoi d'un email de confirmation
    $to = $_SESSION['user_email']; // Assurez-vous que l'email de l'utilisateur est stocké dans la session
    

$mj = new \Mailjet\Client('688184a5710c1b090968bd1bf4e3a994', '35f46285111187584ecf66e84be24804', true, ['version' => 'v3.1']);

$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "salaharroum75@gmail.com",
                'Name' => "Cheap"
            ],
            'To' => [
                [
                    'Email' => $_SESSION['mail_user'],
                    'Name' => $_SESSION['username_user']
                ]
            ],
            'Subject' => "🧾 Vos identifiants de commande Cheap",
            'HTMLPart' => "
                <h3>Merci pour votre commande sur Cheap !</h3>
                <p><strong>Produit :</strong> {$compte['nom_produit']}</p>
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


    // Redirection
    header("Location: ../vue/confirmationcommande.php?id_commande=" . $lastId);
    exit();

} catch (Exception $e) {
    echo "Erreur lors de la commande : " . $e->getMessage();
    exit();
}
