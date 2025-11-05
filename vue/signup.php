<?php
session_start();
$site_name = "Cheap";
$current_year = date('Y');
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name ?> - Inscription</title>
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
            <form action="../controller/controllersignup.php" method="POST" class="auth-form">
                <h1>Créez votre compte</h1>
                
                <div class="form-group">
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">S'inscrire</button>
                </div>
                
                <p class="form-footer">
                    Déjà inscrit ? <a href="login.php">Se connecter</a>
                </p>
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
        
        .auth-form h1 {
            margin-bottom: 2rem;
            text-align: center;
            color: var(--primary-color);
        }
        
        .form-actions {
            margin-top: 1.5rem;
        }
        
        .form-actions .btn {
            width: 100%;
        }
        
        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>