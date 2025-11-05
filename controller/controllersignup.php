<?php
/**
 * ========================================
 * CONTRÔLEUR SIGNUP
 * ========================================
 * Gère l'inscription des nouveaux utilisateurs
 */

session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

try {
    // Obtenir la connexion à la base de données
    $bdd = pdo();

    // Vérification CSRF si disponible
    if (isset($_POST['csrf_token']) && !verify_csrf_token($_POST['csrf_token'])) {
        throw new Exception("Token de sécurité invalide. Veuillez réessayer.");
    }

    // Vérification que les champs ne sont pas vides
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        throw new Exception("Tous les champs sont obligatoires");
    }

    // Récupération et nettoyage des données
    $username = trim(htmlspecialchars($_POST['username']));
    $mail = trim(strtolower($_POST['email']));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validation du nom d'utilisateur
    if (strlen($username) < 3) {
        throw new Exception("Le nom d'utilisateur doit contenir au moins 3 caractères.");
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        throw new Exception("Le nom d'utilisateur ne peut contenir que des lettres, chiffres et underscores.");
    }

    // Validation de l'email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Format d'email invalide.");
    }

    // Validation de la force du mot de passe
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        throw new Exception("Le mot de passe doit contenir au moins " . PASSWORD_MIN_LENGTH . " caractères.");
    }

    // Vérifier que les mots de passe correspondent
    if ($password !== $confirmPassword) {
        throw new Exception("Les mots de passe ne correspondent pas.");
    }

    // Vérification force du mot de passe (au moins une majuscule, un chiffre)
    if (!preg_match('/[A-Z]/', $password)) {
        throw new Exception("Le mot de passe doit contenir au moins une lettre majuscule.");
    }

    if (!preg_match('/[0-9]/', $password)) {
        throw new Exception("Le mot de passe doit contenir au moins un chiffre.");
    }

    // Vérifier si l'email existe déjà
    $requete = "SELECT * FROM users WHERE mail_user = ?";
    $stmt = $bdd->prepare($requete);
    $stmt->execute([$mail]);
    $existingEmail = $stmt->fetch();

    if ($existingEmail) {
        throw new Exception("Cet email est déjà utilisé.");
    }

    // Vérifier si le nom d'utilisateur existe déjà
    $requete = "SELECT * FROM users WHERE username_user = ?";
    $stmt = $bdd->prepare($requete);
    $stmt->execute([$username]);
    $existingUsername = $stmt->fetch();

    if ($existingUsername) {
        throw new Exception("Ce nom d'utilisateur est déjà pris.");
    }

    // Hachage sécurisé du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $requete = "INSERT INTO users (username_user, mail_user, password_user, type_user, created_at) VALUES (?, ?, ?, 'user', NOW())";
    $stmt = $bdd->prepare($requete);
    $stmt->execute([$username, $mail, $hashedPassword]);

    // Récupérer l'ID du nouvel utilisateur
    $userId = $bdd->lastInsertId();

    // Logger l'inscription
    logger("New user registered: {$username} (ID: {$userId}) - Email: {$mail}", 'info');

    // Régénérer l'ID de session (sécurité)
    session_regenerate_id(true);

    // Connexion automatique après inscription
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
    $_SESSION['email_user'] = $mail;
    $_SESSION['type_user'] = 'user';
    $_SESSION['logged_in_at'] = time();

    // Message flash de succès
    set_flash('success', "Bienvenue {$username} ! Votre compte a été créé avec succès.", 'success');

    // Redirection vers le tableau de bord
    redirect('../vue/home.php');
    exit();

} catch(Exception $e) {
    // Gestion des erreurs avec message stylisé
    logger('Signup error: ' . $e->getMessage(), 'error');

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo APP_NAME; ?> - Erreur d'inscription</title>
        <link rel="stylesheet" href="../style/enhanced-styles.css">
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error-container {
                background: white;
                border-radius: 20px;
                padding: 3rem;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                max-width: 500px;
                text-align: center;
                animation: slideInUp 0.5s ease;
            }
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .error-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                animation: shake 0.5s ease;
            }
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
            .error-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #dc2626;
                margin-bottom: 1rem;
            }
            .error-message {
                color: #6b7280;
                line-height: 1.6;
                margin-bottom: 2rem;
            }
            .btn {
                display: inline-block;
                padding: 0.75rem 2rem;
                background: linear-gradient(135deg, #f093fb, #f5576c);
                color: white;
                text-decoration: none;
                border-radius: 10px;
                font-weight: 600;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(240, 147, 251, 0.4);
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-icon">⚠️</div>
            <h1 class="error-title">Erreur d'inscription</h1>
            <p class="error-message"><?php echo htmlspecialchars($e->getMessage()); ?></p>
            <a href="../vue/signup.php" class="btn">Retour à l'inscription</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}
