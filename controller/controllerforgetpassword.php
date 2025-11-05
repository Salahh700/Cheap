<?php
require '../vendor/autoload.php';   // <-- mets ça tout en haut
use \Mailjet\Resources;

session_start();

// Connexion à la base
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération et validation de l'email
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Adresse email invalide.";
    exit();
}

// Vérification de l'utilisateur
$stmt = $bdd->prepare("SELECT * FROM users WHERE mail_user = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    $reset_token = bin2hex(random_bytes(16));

    // Enregistrer le token
    $stmt = $bdd->prepare("UPDATE users SET reset_token = ? WHERE mail_user = ?");
    $stmt->execute([$reset_token, $email]);

    // Envoi de l'email avec Mailjet
    $mj = new \Mailjet\Client('688184a5710c1b090968bd1bf4e3a994', '35f46285111187584ecf66e84be24804', true, ['version' => 'v3.1']);

    $body = [
        'Messages' => [[
            'From' => [
                'Email' => "salaharroum93@gmail.com",
                'Name'  => "Cheap"
            ],
            'To' => [[
                'Email' => $email,
                'Name'  => "Utilisateur Cheap"
            ]],
            'Subject' => "Réinitialisation de votre mot de passe sur Cheap",
            'HTMLPart' => "
                <h3>Bonjour,</h3>
                <p>Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le lien ci-dessous pour le réinitialiser :</p>
                <a href='http://localhost/Yanis/vue/resetpassword.php?token=$reset_token'>Réinitialiser mon mot de passe</a>
                <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.</p>
                <br>
                <p>Cordialement,<br>L'équipe Cheap</p>
            "
        ]]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);

    if ($response->success()) {
        echo "Un email de réinitialisation a été envoyé à $email.";
    } else {
        echo "Erreur lors de l'envoi de l'email.";
    }

    echo "<p><a href='../vue/login.php'>Retour à la page de connexion</a></p>";
    exit();
} else {
    echo "Erreur : Cet email n'est pas enregistré.";
    echo "<p><a href='../vue/forgetpassword.php'>Retour à la page de mot de passe oublié</a></p>";
    exit();
}
?>
