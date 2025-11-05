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
    <link rel="stylesheet" href="../style/sections.css">
    <script src="../style/app.js" defer></script>
    <script src="../style/advanced-animations.js" defer></script>
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <p class="loader-text">Chargement...</p>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1 class="logo-text gradient-text">
                        <span class="music-icon">🎵</span>
                        <?php echo $site_name; ?>
                    </h1>
                </div>
                <div class="header-actions">
                    <button class="btn btn-outline focus-ring" onclick="window.location.href='login.php'">
                        Se connecter
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section avec particules animées -->
    <section class="hero particles-bg">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-title fade-in-up typing-text">
                    Comptes Premium Numériques
                </h2>
                <p class="hero-subtitle fade-in-up">
                    Obtenez un accès instantané à vos services de streaming préférés
                </p>
                <div class="hero-buttons fade-in-up">
                    <button class="btn btn-primary btn-modern glow-hover" onclick="window.location.href='signup.php'">
                        Parcourir les comptes
                    </button>
                    <button class="btn btn-secondary btn-modern" onclick="document.getElementById('services').scrollIntoView({behavior: 'smooth'})">
                        En savoir plus
                    </button>
                </div>
            </div>
        </div>
        <!-- Animated waves -->
        <div class="waves">
            <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- Stats Section avec compteurs animés -->
    <section class="stats particles-bg glass-card">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item fade-in-up pulse-ring">
                    <div class="stat-number" data-target="1000">0</div>
                    <div class="stat-label">Comptes actifs</div>
                </div>
                <div class="stat-item fade-in-up pulse-ring">
                    <div class="stat-number" data-target="15">0</div>
                    <div class="stat-label">Types de services</div>
                </div>
                <div class="stat-item fade-in-up pulse-ring">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support</div>
                </div>
                <div class="stat-item fade-in-up pulse-ring">
                    <div class="stat-number" data-target="99.9">0</div>
                    <div class="stat-label">% Disponibilité</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="features">
        <div class="container">
            <div class="features-header fade-in-up">
                <h2 class="features-title gradient-text">Pourquoi choisir <?php echo $site_name; ?>?</h2>
                <p class="features-subtitle">Accès sécurisé, fiable et instantané aux comptes premium</p>
            </div>

            <div class="features-grid">
                <div class="feature-item lift-hover scale-in neumorphic">
                    <div class="feature-icon feature-icon-primary heartbeat">
                        🛡️
                    </div>
                    <h3 class="feature-title">Paiements sécurisés</h3>
                    <p class="feature-description">Toutes les transactions sont cryptées et sécurisées avec une protection SSL et Stripe. Vos données bancaires ne sont jamais stockées sur nos serveurs.</p>
                </div>

                <div class="feature-item lift-hover scale-in neumorphic">
                    <div class="feature-icon feature-icon-accent heartbeat">
                        ⚡
                    </div>
                    <h3 class="feature-title">Livraison instantanée</h3>
                    <p class="feature-description">Recevez vos identifiants de compte instantanément après l'achat par email. Pas d'attente, accédez immédiatement à vos services.</p>
                </div>

                <div class="feature-item lift-hover scale-in neumorphic">
                    <div class="feature-icon feature-icon-orange heartbeat">
                        🎧
                    </div>
                    <h3 class="feature-title">Support 24/7</h3>
                    <p class="feature-description">Notre équipe de support dédiée est disponible 24h/24 et 7j/7 pour répondre à toutes vos questions et résoudre vos problèmes.</p>
                </div>

                <div class="feature-item lift-hover scale-in neumorphic">
                    <div class="feature-icon feature-icon-primary heartbeat">
                        💎
                    </div>
                    <h3 class="feature-title">Qualité Premium</h3>
                    <p class="feature-description">Tous nos comptes sont vérifiés et testés. Nous garantissons un accès premium authentique à tous vos services préférés.</p>
                </div>

                <div class="feature-item lift-hover scale-in neumorphic">
                    <div class="feature-icon feature-icon-accent heartbeat">
                        🔄
                    </div>
                    <h3 class="feature-title">Garantie de remplacement</h3>
                    <p class="feature-description">En cas de problème avec votre compte, nous le remplaçons gratuitement dans les 24 heures. Votre satisfaction est notre priorité.</p>
                </div>

                <div class="feature-item lift-hover scale-in neumorphic">
                    <div class="feature-icon feature-icon-orange heartbeat">
                        💰
                    </div>
                    <h3 class="feature-title">Prix imbattables</h3>
                    <p class="feature-description">Profitez de tarifs jusqu'à 70% moins chers que les abonnements officiels. Le meilleur rapport qualité-prix du marché.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section particles-bg">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title gradient-text">Nos Tarifs</h2>
                <p class="section-subtitle">Choisissez l'offre qui vous convient</p>
            </div>

            <div class="pricing-grid">
                <div class="pricing-card scale-in lift-hover">
                    <div class="pricing-badge">Populaire</div>
                    <div class="pricing-icon">🎵</div>
                    <h3 class="pricing-title">Spotify Premium</h3>
                    <div class="pricing-price">
                        <span class="price">3.99€</span>
                        <span class="period">/mois</span>
                    </div>
                    <ul class="pricing-features">
                        <li>✓ Écoute illimitée</li>
                        <li>✓ Sans publicités</li>
                        <li>✓ Téléchargement offline</li>
                        <li>✓ Qualité audio supérieure</li>
                    </ul>
                    <button class="pricing-btn btn-gradient-shift" onclick="window.location.href='signup.php'">
                        Commander maintenant
                    </button>
                </div>

                <div class="pricing-card scale-in lift-hover featured">
                    <div class="pricing-badge badge-success">Meilleure offre</div>
                    <div class="pricing-icon">🎬</div>
                    <h3 class="pricing-title">Netflix Premium</h3>
                    <div class="pricing-price">
                        <span class="price">4.99€</span>
                        <span class="period">/mois</span>
                    </div>
                    <ul class="pricing-features">
                        <li>✓ Qualité 4K Ultra HD</li>
                        <li>✓ 4 écrans simultanés</li>
                        <li>✓ Téléchargement illimité</li>
                        <li>✓ Catalogue complet</li>
                    </ul>
                    <button class="pricing-btn btn-gradient-shift" onclick="window.location.href='signup.php'">
                        Commander maintenant
                    </button>
                </div>

                <div class="pricing-card scale-in lift-hover">
                    <div class="pricing-badge">Nouveau</div>
                    <div class="pricing-icon">📺</div>
                    <h3 class="pricing-title">Disney+ Premium</h3>
                    <div class="pricing-price">
                        <span class="price">3.49€</span>
                        <span class="period">/mois</span>
                    </div>
                    <ul class="pricing-features">
                        <li>✓ Marvel, Star Wars, Pixar</li>
                        <li>✓ Qualité 4K</li>
                        <li>✓ 4 appareils simultanés</li>
                        <li>✓ Téléchargement offline</li>
                    </ul>
                    <button class="pricing-btn btn-gradient-shift" onclick="window.location.href='signup.php'">
                        Commander maintenant
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title gradient-text">Ce que disent nos clients</h2>
                <p class="section-subtitle">Plus de 10 000 clients satisfaits</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card fade-in-left lift-hover">
                    <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">"Service impeccable ! J'ai reçu mon compte Spotify en moins de 2 minutes. Le support client est très réactif."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👤</div>
                        <div class="author-info">
                            <div class="author-name">Marie D.</div>
                            <div class="author-role">Cliente depuis 6 mois</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-in-up lift-hover">
                    <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">"Meilleur prix du marché ! J'économise plus de 100€ par an sur mes abonnements streaming. Je recommande vivement."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👨</div>
                        <div class="author-info">
                            <div class="author-name">Thomas L.</div>
                            <div class="author-role">Client depuis 1 an</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-in-right lift-hover">
                    <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">"J'étais sceptique au début, mais après 8 mois d'utilisation, aucun problème. Service fiable et professionnel."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">👩</div>
                        <div class="author-info">
                            <div class="author-name">Sophie M.</div>
                            <div class="author-role">Cliente depuis 8 mois</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section particles-bg">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title gradient-text">Questions Fréquentes</h2>
                <p class="section-subtitle">Tout ce que vous devez savoir</p>
            </div>

            <div class="faq-container">
                <div class="faq-item scale-in">
                    <div class="faq-question">
                        <h3>Comment fonctionne le service ?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Après votre commande, vous recevez instantanément par email les identifiants de connexion du compte premium. Vous pouvez alors vous connecter et profiter de tous les avantages premium.</p>
                    </div>
                </div>

                <div class="faq-item scale-in">
                    <div class="faq-question">
                        <h3>Les comptes sont-ils légaux ?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Oui, tous nos comptes sont 100% légaux. Nous achetons des abonnements groupés auprès des fournisseurs officiels et les redistribuons à prix réduit.</p>
                    </div>
                </div>

                <div class="faq-item scale-in">
                    <div class="faq-question">
                        <h3>Que se passe-t-il si mon compte ne fonctionne plus ?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Nous offrons une garantie de remplacement gratuite. Contactez notre support et nous vous fournirons un nouveau compte dans les 24 heures.</p>
                    </div>
                </div>

                <div class="faq-item scale-in">
                    <div class="faq-question">
                        <h3>Puis-je partager mon compte ?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Les comptes sont personnels. Cependant, certains services comme Netflix permettent plusieurs profils. Consultez les conditions de chaque service.</p>
                    </div>
                </div>

                <div class="faq-item scale-in">
                    <div class="faq-question">
                        <h3>Quels moyens de paiement acceptez-vous ?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Nous acceptons toutes les cartes bancaires (Visa, Mastercard, American Express) via notre système de paiement sécurisé Stripe.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section gradient-animated">
        <div class="container">
            <div class="cta-content fade-in-up">
                <h2 class="cta-title">Prêt à commencer ?</h2>
                <p class="cta-text">Rejoignez des milliers d'utilisateurs satisfaits et profitez de vos services préférés à prix réduit</p>
                <button class="cta-btn btn-modern" onclick="window.location.href='signup.php'">
                    Créer mon compte gratuitement
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3 class="footer-logo gradient-text">
                        <span class="music-icon">🎵</span>
                        <?php echo $site_name; ?>
                    </h3>
                    <p class="footer-description">Votre source de confiance pour des comptes numériques premium à des prix imbattables.</p>
                </div>

                <div class="footer-links">
                    <h4 class="footer-heading">Liens rapides</h4>
                    <ul class="footer-list">
                        <li><a href="#services" class="footer-link">Services</a></li>
                        <li><a href="#" class="footer-link">À propos</a></li>
                        <li><a href="#" class="footer-link">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4 class="footer-heading">Types de comptes</h4>
                    <ul class="footer-list">
                        <li><a href="#" class="footer-link">Streaming musical</a></li>
                        <li><a href="#" class="footer-link">Streaming vidéo</a></li>
                        <li><a href="#" class="footer-link">Gaming</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4 class="footer-heading">Légal</h4>
                    <ul class="footer-list">
                        <li><a href="#" class="footer-link">Mentions légales</a></li>
                        <li><a href="#" class="footer-link">CGV</a></li>
                        <li><a href="#" class="footer-link">Confidentialité</a></li>
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
