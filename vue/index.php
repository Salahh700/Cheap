<?php
$site_name = "Cheap";
$current_year = date('Y');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - Comptes Premium Numériques</title>
    <meta name="description" content="Obtenez un accès instantané aux comptes premium pour les services de streaming comme Spotify, Netflix et plus encore à des prix imbattables.">
    
    <!-- Open Graph tags -->
    <meta property="og:title" content="<?php echo $site_name; ?> - Comptes Premium Numériques">
    <meta property="og:description" content="Obtenez un accès instantané aux comptes premium pour les services de streaming">
    <meta property="og:type" content="website">
    
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/enhanced-styles.css">
    <script src="../style/app.js" defer></script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1 class="logo-text">
                        <span class="music-icon">🎵</span>
                        <?php echo $site_name; ?>
                    </h1>
                </div>
                <div class="header-actions">
                    <button class="btn btn-outline" onclick="window.location.href='login.php'">
                        Se connecter
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-title">Comptes Premium Numériques</h2>
                <p class="hero-subtitle">Obtenez un accès instantané à vos services de streaming préférés</p>
                <div class="hero-buttons">
                    <button class="btn btn-primary" onclick="window.location.href='signup.php'">
                        Parcourir les comptes
                    </button>
                    <button class="btn btn-secondary">
                        En savoir plus
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats particles-bg">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item fade-in-up">
                    <div class="stat-number">100-1000</div>
                    <div class="stat-label">Comptes actifs</div>
                </div>
                <div class="stat-item fade-in-up">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Types de services</div>
                </div>
                <div class="stat-item fade-in-up">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support</div>
                </div>
                <div class="stat-item fade-in-up">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Disponibilité</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-header">
                <h2 class="features-title">Pourquoi choisir <?php echo $site_name; ?>?</h2>
                <p class="features-subtitle">Accès sécurisé, fiable et instantané aux comptes premium</p>
            </div>

            <div class="features-grid">
                <div class="feature-item lift-hover scale-in">
                    <div class="feature-icon feature-icon-primary">
                        🛡️
                    </div>
                    <h3 class="feature-title">Paiements sécurisés</h3>
                    <p class="feature-description">Toutes les transactions sont cryptées et sécurisées avec une protection SSL</p>
                </div>

                <div class="feature-item lift-hover scale-in">
                    <div class="feature-icon feature-icon-accent">
                        ⚡
                    </div>
                    <h3 class="feature-title">Livraison instantanée</h3>
                    <p class="feature-description">Recevez vos identifiants de compte instantanément après l'achat par mail</p>
                </div>

                <div class="feature-item lift-hover scale-in">
                    <div class="feature-icon feature-icon-orange">
                        🎧
                    </div>
                    <h3 class="feature-title">Support 24/7</h3>
                    <p class="feature-description">Notre équipe de support dédiée est disponible 24h/24 et 7j/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3 class="footer-logo">
                        <span class="music-icon">🎵</span>
                        <?php echo $site_name; ?>
                    </h3>
                    <p class="footer-description">Votre source de confiance pour des comptes numériques premium à des prix imbattables.</p>
                </div>
                
                <div class="footer-links">
                    <h4 class="footer-heading">Liens rapides</h4>
                    <ul class="footer-list">
                        <li><a href="#" class="footer-link">À propos</a></li>
                        <li><a href="#" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h4 class="footer-heading">Types de comptes</h4>
                    <ul class="footer-list">
                        <li><a href="#" class="footer-link">Streaming musical</a></li>
                        <li><a href="#" class="footer-link">Streaming vidéo</a></li>
                    </ul>
                </div>
                
            </div>
            
            <div class="footer-bottom">
                <p class="footer-copyright">&copy; <?php echo $current_year; ?> <?php echo $site_name; ?>. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>