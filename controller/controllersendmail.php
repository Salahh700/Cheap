<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Inclure Composer
use \Mailjet\Resources;

session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../vue/login.php');
    exit();
}

// Exemple d'identifiants fictifs (à remplacer par des vrais issus de la BDD ou commande)
$email_destinataire = 'destinataire@email.com'; // Remplace ça dynamiquement plus tard
$identifiant_compte = 'user123';
$mdp_compte = 'pass123';

$mj = new \Mailjet\Client('VOTRE_API_KEY', 'VOTRE_API_SECRET', true, ['version' => 'v3.1']);

$body = [
  'Messages' => [
    [
      'From' => [
        'Email' => "noreply@cheap.com",
        'Name' => "Cheap"
      ],
      'To' => [
        [
          'Email' => $email_destinataire,
          'Name' => "Client"
        ]
      ],
      'Subject' => "Voici ton abonnement de Cheap 🎧",
      'TextPart' => "Bonjour,\n\nVoici ton compte :\nIdentifiant : $identifiant_compte\nMot de passe : $mdp_compte\n\nMerci pour ta confiance !\nL'équipe Cheap",
      'HTMLPart' => "<h3>Voici ton compte 🎧</h3><p><strong>Identifiant :</strong> $identifiant_compte<br><strong>Mot de passe :</strong> $mdp_compte</p><p>Merci pour ta confiance,<br>L'équipe Cheap</p>"
    ]
  ]
];

$response = $mj->post(Resources::$Email, ['body' => $body]);

if ($response->success()) {
    echo "✉️ Mail envoyé avec succès !";
} else {
    echo "❌ Erreur lors de l'envoi du mail : " . $response->getStatus() . "<br>";
    print_r($response->getBody());
}
?>

