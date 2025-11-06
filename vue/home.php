<?php
session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$site_name = "Cheap";
$page_title = "$site_name - Boutique";
$current_page = 'home';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
try {
    $bdd = pdo();
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/unified-theme.css">
    <style>
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-xl);
            margin-top: var(--spacing-2xl);
        }

        .product-card {
            background: white;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-base);
            border: 1px solid var(--border-color);
        }

        .product-card:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-8px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid var(--border-color);
        }

        .product-content {
            padding: var(--spacing-lg);
        }

        .product-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
        }

        .product-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: var(--spacing-lg);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: var(--spacing-md);
            border-top: 1px solid var(--border-color);
        }

        .product-price {
            font-size: 24px;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: var(--spacing-3xl);
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/unified-header.php'; ?>

    <div class="main-content">
        <div class="container-unified">
            <!-- Section d'accueil -->
            <div class="text-center" style="margin-bottom: var(--spacing-3xl);">
                <h1 style="font-size: 38px; font-weight: 800; margin-bottom: var(--spacing-md);">
                    Découvrez nos <span class="gradient-text">Comptes Premium</span>
                </h1>
                <p style="font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 0 auto;">
                    Accédez instantanément à vos services de streaming préférés au meilleur prix
                </p>
            </div>

            <!-- Grille de produits -->
            <div class="products-grid">
                <?php
                $query = $bdd->prepare("SELECT * FROM produits ORDER BY nom_produit");
                $query->execute();
                $produits = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($produits):
                    foreach ($produits as $product): ?>
                        <div class="product-card fade-in-unified">
                            <img
                                src="afficherimage.php?id=<?php echo $product['id_produit']; ?>"
                                alt="<?php echo htmlspecialchars($product['nom_produit']); ?>"
                                class="product-image"
                                loading="lazy"
                            >
                            <div class="product-content">
                                <h3 class="product-title">
                                    <?php echo htmlspecialchars($product['nom_produit']); ?>
                                </h3>
                                <p class="product-description">
                                    <?php echo htmlspecialchars($product['description_produit']); ?>
                                </p>

                                <div class="product-footer">
                                    <div class="product-price">
                                        <?php echo number_format($product['prix_produit'], 2); ?> €
                                    </div>
                                    <form action="../stripe/checkout.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($product['id_produit']); ?>">
                                        <button type="submit" class="btn-unified btn-unified-primary">
                                            🛒 Acheter
                                        </button>
                                    </form>
                                </div>

                                <?php if (isset($product['stock_produit']) && $product['stock_produit'] > 0): ?>
                                    <div style="margin-top: var(--spacing-md);">
                                        <span class="badge-unified badge-success">
                                            ✓ <?php echo $product['stock_produit']; ?> en stock
                                        </span>
                                    </div>
                                <?php elseif (isset($product['stock_produit'])): ?>
                                    <div style="margin-top: var(--spacing-md);">
                                        <span class="badge-unified badge-warning">
                                            ⚠ Rupture de stock
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach;
                else: ?>
                    <div class="no-products">
                        <div style="font-size: 64px; margin-bottom: var(--spacing-lg);">📦</div>
                        <h3 style="font-size: 24px; margin-bottom: var(--spacing-sm);">Aucun produit disponible</h3>
                        <p>Revenez bientôt pour découvrir nos offres !</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Section avantages -->
            <div style="margin-top: var(--spacing-3xl); padding-top: var(--spacing-3xl); border-top: 2px solid var(--border-color);">
                <h2 class="text-center" style="font-size: 28px; font-weight: 700; margin-bottom: var(--spacing-2xl);">
                    Pourquoi choisir Cheap ?
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-xl);">
                    <div class="card-unified text-center">
                        <div style="font-size: 48px; margin-bottom: var(--spacing-md);">⚡</div>
                        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: var(--spacing-sm);">Livraison Instantanée</h3>
                        <p style="font-size: 14px; color: var(--text-secondary);">Recevez vos identifiants par email en quelques secondes</p>
                    </div>
                    <div class="card-unified text-center">
                        <div style="font-size: 48px; margin-bottom: var(--spacing-md);">🔒</div>
                        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: var(--spacing-sm);">Paiement Sécurisé</h3>
                        <p style="font-size: 14px; color: var(--text-secondary);">Transactions cryptées avec Stripe</p>
                    </div>
                    <div class="card-unified text-center">
                        <div style="font-size: 48px; margin-bottom: var(--spacing-md);">💎</div>
                        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: var(--spacing-sm);">Comptes Premium</h3>
                        <p style="font-size: 14px; color: var(--text-secondary);">Tous nos comptes sont 100% fonctionnels</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
