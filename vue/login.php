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
    <title><?php echo $site_name ?> - Connectez-vous</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/modern.css">
    <script src="../style/app.js" defer></script>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="signup.php">S'inscrire</a></li>
            </ul>
        </nav>

        <div class="form-container">
            <form action="../controller/controllerlogin.php" method="POST" class="auth-form">
                <h1>Connectez-vous</h1>
                
                <div class="form-group">
                    <label for="username">Nom d'utilisateur ou Email :</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Se connecter</button>
                    <a href="forgetpassword.php" class="btn btn-secondary">Mot de passe oublié ?</a>
                </div>
                
                <p class="form-footer">
                    Pas encore inscrit? <a href="signup.php">S'inscrire</a>
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
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
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