<?php
$site_name = "Cheap";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name ?> - Mot de passe oublié</title>
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
                <li><a href="signup.php">S'inscrire</a></li>
            </ul>
        </nav>

        <div class="form-container">
            <form action="../controller/controllerforgetpassword.php" method="POST" class="auth-form">
                <div class="form-header">
                    <h1>Mot de passe oublié ?</h1>
                    <p class="form-description">Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" required placeholder="Entrez votre adresse e-mail">
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
</body>
</html>