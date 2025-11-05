<?php
$site_name = "Cheap";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name ?> - Réinitialisation du mot de passe</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/modern.css">
    <script src="../style/app.js" defer></script>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="login.php">Se connecter</a></li>
            </ul>
        </nav>

        <div class="form-container">
            <form action="../controller/controllerresetpassword.php" method="POST" class="auth-form">
                <div class="form-header">
                    <h1>Nouveau mot de passe</h1>
                    <p class="form-description">Choisissez un nouveau mot de passe pour votre compte.</p>
                </div>

                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password" 
                        required
                        minlength="8"
                        class="password-input"
                    >
                    <small class="password-hint">Le mot de passe doit contenir au moins 8 caractères</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        required
                        class="password-input"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Réinitialiser le mot de passe</button>
                </div>

                <div class="form-links">
                    <a href="login.php">← Retour à la connexion</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--white);
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h1 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .form-description {
            color: var(--text-color);
            opacity: 0.7;
            line-height: 1.5;
        }

        .password-input {
            margin-bottom: 0.25rem;
        }

        .password-hint {
            display: block;
            color: var(--text-color);
            opacity: 0.6;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .form-actions {
            margin: 2rem 0;
        }

        .form-actions .btn {
            width: 100%;
        }

        .form-links {
            text-align: center;
        }

        .form-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .form-links a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('new_password').value;
            const confirm = document.getElementById('confirm_password').value;

            if (password !== confirm) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas !');
            }
        });
    </script>
</body>
</html>