<?php
session_start();

$site_name = "Cheap";
$page_title = "$site_name - Connexion";
$current_page = 'login';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/unified-theme.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/unified-header.php'; ?>

    <div class="main-content">
        <div class="container-unified" style="max-width: 480px;">
            <div class="card-unified fade-in-unified">
                <div class="card-unified-header text-center">
                    <h1 class="card-unified-title" style="font-size: 28px;">Bon retour ! 👋</h1>
                    <p class="card-unified-subtitle">Connectez-vous pour accéder à vos comptes premium</p>
                </div>

                <form action="../controller/controllerlogin.php" method="POST" class="form-unified">
                    <div class="form-group-unified">
                        <label for="username" class="form-label-unified">
                            📧 Nom d'utilisateur ou Email
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-input-unified"
                            placeholder="Entrez votre username ou email"
                            required
                            autocomplete="username"
                        >
                    </div>

                    <div class="form-group-unified">
                        <label for="password" class="form-label-unified">
                            🔒 Mot de passe
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input-unified"
                            placeholder="Entrez votre mot de passe"
                            required
                            autocomplete="current-password"
                        >
                    </div>

                    <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
                        <button type="submit" class="btn-unified btn-unified-primary" style="flex: 1;">
                            Se connecter
                        </button>
                    </div>

                    <div style="text-align: center; margin-top: var(--spacing-lg);">
                        <a href="forgetpassword.php" style="color: var(--text-secondary); font-size: 14px; text-decoration: none;">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <div style="text-align: center; margin-top: var(--spacing-xl); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color);">
                        <span style="color: var(--text-secondary); font-size: 14px;">
                            Pas encore de compte ?
                        </span>
                        <a href="signup.php" style="color: var(--primary-color); font-weight: 600; text-decoration: none; margin-left: 4px;">
                            S'inscrire gratuitement
                        </a>
                    </div>
                </form>
            </div>

            <!-- Avantages -->
            <div style="margin-top: var(--spacing-2xl); text-align: center;">
                <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: var(--spacing-md);">
                    ✨ Plus de 1000 clients satisfaits
                </p>
                <div style="display: flex; justify-content: center; gap: var(--spacing-lg); flex-wrap: wrap;">
                    <span class="badge-unified badge-primary">🔒 Paiement Sécurisé</span>
                    <span class="badge-unified badge-success">⚡ Livraison Instantanée</span>
                    <span class="badge-unified badge-primary">💎 Comptes Premium</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
