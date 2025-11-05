<?php
/**
 * ========================================
 * CONTRÔLEUR LOGIN
 * ========================================
 * Gère l'authentification des utilisateurs
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
    if (empty($_POST['username']) || empty($_POST['password'])) {
        throw new Exception("Tous les champs sont obligatoires");
    }

    // Récupération des données du formulaire avec nettoyage
    $username = trim(htmlspecialchars($_POST['username']));
    $password = $_POST['password'];

    // Vérifier le nombre de tentatives de connexion (protection brute force)
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $cache_key = 'login_attempts_' . md5($ip_address);

    if (!isset($_SESSION[$cache_key])) {
        $_SESSION[$cache_key] = ['count' => 0, 'time' => time()];
    }

    // Réinitialiser après 15 minutes
    if (time() - $_SESSION[$cache_key]['time'] > 900) {
        $_SESSION[$cache_key] = ['count' => 0, 'time' => time()];
    }

    // Bloquer après 5 tentatives
    if ($_SESSION[$cache_key]['count'] >= MAX_LOGIN_ATTEMPTS) {
        throw new Exception("Trop de tentatives de connexion. Veuillez réessayer dans 15 minutes.");
    }

    // Préparation de la requête pour trouver l'utilisateur
    $requete = "SELECT * FROM users WHERE username_user = ? OR mail_user = ?";
    $stmt = $bdd->prepare($requete);
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password_user'])) {
        // Connexion réussie - réinitialiser les tentatives
        $_SESSION[$cache_key] = ['count' => 0, 'time' => time()];

        // Régénérer l'ID de session (protection contre la fixation de session)
        session_regenerate_id(true);

        // Stockage des informations en session
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username_user'];
        $_SESSION['type_user'] = $user['type_user'];
        $_SESSION['email_user'] = $user['mail_user'];
        $_SESSION['logged_in_at'] = time();

        // Logger la connexion
        logger("User logged in: {$user['username_user']} (ID: {$user['id_user']})", 'info');

        // Message flash de succès
        set_flash('success', "Bienvenue {$user['username_user']} !", 'success');

        // Redirection selon le rôle
        if ($user['type_user'] === 'admin') {
            redirect('../vue/paneladmin.php');
        } else {
            redirect('../vue/home.php');
        }
        exit();
    } else {
        // Incrémenter le compteur de tentatives
        $_SESSION[$cache_key]['count']++;
        $remaining = MAX_LOGIN_ATTEMPTS - $_SESSION[$cache_key]['count'];

        logger("Failed login attempt for username: {$username} from IP: {$ip_address}", 'warning');

        if ($remaining > 0) {
            throw new Exception("Nom d'utilisateur ou mot de passe incorrect. Il vous reste {$remaining} tentative(s).");
        } else {
            throw new Exception("Trop de tentatives de connexion. Compte temporairement bloqué.");
        }
    }

} catch(Exception $e) {
    // Gestion des erreurs avec message stylisé
    logger('Login error: ' . $e->getMessage(), 'error');

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo APP_NAME; ?> - Erreur de connexion</title>
        <link rel="stylesheet" href="../style/enhanced-styles.css">
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                text-decoration: none;
                border-radius: 10px;
                font-weight: 600;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-icon">🔒</div>
            <h1 class="error-title">Erreur de connexion</h1>
            <p class="error-message"><?php echo htmlspecialchars($e->getMessage()); ?></p>
            <a href="../vue/login.php" class="btn">Retour à la connexion</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}
