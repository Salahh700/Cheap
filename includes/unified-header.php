<?php
/**
 * ========================================
 * HEADER UNIFORME - CHEAP
 * ========================================
 * À inclure dans toutes les pages pour un header cohérent
 */

// Définir les variables si elles n'existent pas
if (!isset($site_name)) $site_name = "Cheap";
if (!isset($page_title)) $page_title = $site_name;
if (!isset($current_page)) $current_page = '';

// Vérifier si l'utilisateur est connecté
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'admin';
$username = $is_logged_in ? $_SESSION['username'] : '';
?>

<header class="unified-header" id="mainHeader">
    <div class="container">
        <div class="unified-header-content">
            <!-- Logo Cheap -->
            <a href="<?php echo $is_logged_in ? 'home.php' : 'index.php'; ?>" class="cheap-logo">
                <div class="cheap-logo-icon">
                    💎
                </div>
                <div>
                    <div class="cheap-logo-text">CHEAP</div>
                    <div class="cheap-logo-tagline">Premium Deals</div>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="unified-nav">
                <?php if (!$is_logged_in): ?>
                    <!-- Menu pour utilisateurs non connectés -->
                    <a href="index.php" class="<?php echo $current_page == 'index' ? 'active' : ''; ?>">Accueil</a>
                    <a href="login.php" class="<?php echo $current_page == 'login' ? 'active' : ''; ?>">Connexion</a>
                    <a href="signup.php" class="btn-unified btn-unified-primary">S'inscrire</a>
                <?php else: ?>
                    <!-- Menu pour utilisateurs connectés -->
                    <a href="home.php" class="<?php echo $current_page == 'home' ? 'active' : ''; ?>">🛍️ Boutique</a>
                    <a href="profil.php" class="<?php echo $current_page == 'profil' ? 'active' : ''; ?>">👤 Profil</a>

                    <?php if ($is_admin): ?>
                        <a href="paneladmin.php" class="<?php echo $current_page == 'admin' ? 'active' : ''; ?>">⚙️ Admin</a>
                    <?php endif; ?>

                    <span style="color: var(--text-secondary); font-size: 14px; margin: 0 8px;">
                        👋 <?php echo htmlspecialchars($username); ?>
                    </span>

                    <a href="../controller/controllerlogout.php" class="btn-unified btn-unified-ghost">
                        Déconnexion
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

<script>
// Ajouter classe 'scrolled' au header lors du scroll
window.addEventListener('scroll', function() {
    const header = document.getElementById('mainHeader');
    if (window.scrollY > 20) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>
