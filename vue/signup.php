<?php
session_start();

$site_name = "Cheap";
$page_title = "$site_name - Inscription";
$current_page = 'signup';
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
                    <h1 class="card-unified-title" style="font-size: 28px;">Rejoignez-nous ! 🚀</h1>
                    <p class="card-unified-subtitle">Créez votre compte et accédez à nos offres premium</p>
                </div>

                <form action="../controller/controllersignup.php" method="POST" class="form-unified">
                    <div class="form-group-unified">
                        <label for="username" class="form-label-unified">
                            👤 Nom d'utilisateur
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-input-unified"
                            placeholder="Choisissez un nom d'utilisateur"
                            required
                            autocomplete="username"
                            minlength="3"
                        >
                        <small style="color: var(--text-tertiary); font-size: 12px; display: block; margin-top: 4px;">
                            Minimum 3 caractères (lettres, chiffres, underscore)
                        </small>
                    </div>

                    <div class="form-group-unified">
                        <label for="email" class="form-label-unified">
                            📧 Adresse Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input-unified"
                            placeholder="votre@email.com"
                            required
                            autocomplete="email"
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
                            placeholder="Choisissez un mot de passe sécurisé"
                            required
                            autocomplete="new-password"
                            minlength="6"
                        >
                        <small style="color: var(--text-tertiary); font-size: 12px; display: block; margin-top: 4px;">
                            Minimum 6 caractères
                        </small>
                    </div>

                    <div style="background: var(--gray-100); padding: var(--spacing-md); border-radius: var(--radius-md); margin: var(--spacing-lg) 0;">
                        <p style="font-size: 12px; color: var(--text-secondary); margin: 0;">
                            ✅ En créant un compte, vous acceptez nos conditions d'utilisation
                        </p>
                    </div>

                    <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
                        <button type="submit" class="btn-unified btn-unified-primary" style="flex: 1;">
                            Créer mon compte
                        </button>
                    </div>

                    <div style="text-align: center; margin-top: var(--spacing-xl); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color);">
                        <span style="color: var(--text-secondary); font-size: 14px;">
                            Vous avez déjà un compte ?
                        </span>
                        <a href="login.php" style="color: var(--primary-color); font-weight: 600; text-decoration: none; margin-left: 4px;">
                            Se connecter
                        </a>
                    </div>
                </form>
            </div>

            <!-- Avantages de l'inscription -->
            <div style="margin-top: var(--spacing-2xl);">
                <h3 style="text-align: center; color: var(--text-primary); font-size: 18px; margin-bottom: var(--spacing-lg);">
                    Pourquoi créer un compte ?
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: var(--spacing-md);">
                    <div style="text-align: center; padding: var(--spacing-md);">
                        <div style="font-size: 32px; margin-bottom: var(--spacing-sm);">⚡</div>
                        <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Livraison Instantanée</div>
                    </div>
                    <div style="text-align: center; padding: var(--spacing-md);">
                        <div style="font-size: 32px; margin-bottom: var(--spacing-sm);">💎</div>
                        <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Comptes Premium</div>
                    </div>
                    <div style="text-align: center; padding: var(--spacing-md);">
                        <div style="font-size: 32px; margin-bottom: var(--spacing-sm);">🔒</div>
                        <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">100% Sécurisé</div>
                    </div>
                    <div style="text-align: center; padding: var(--spacing-md);">
                        <div style="font-size: 32px; margin-bottom: var(--spacing-sm);">💰</div>
                        <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Meilleurs Prix</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
