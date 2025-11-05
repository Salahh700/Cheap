<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
$site_name = "Cheap";
$current_year = date('Y');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheap - Nos abonnements premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/modern.css">
    <link rel="stylesheet" href="../style/enhanced-styles.css">
    <script src="../style/app.js" defer></script>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><span class="logo">🎵 <?php echo $site_name ?></span></li>
                <li><a href="profil.php">Mon profil</a></li>
                <li><a href="../controller/controllerlogout.php" class="btn-secondary">Se déconnecter</a></li>
            </ul>
        </nav>

        <div class="welcome-section">
            <h1>Bienvenue sur <?php echo $site_name ?></h1>
            <p class="subtitle">Choisissez votre abonnement premium et profitez de nos services exclusifs.</p>
        </div>

        <div class="products-grid">
            <?php
            $query = $bdd->prepare("SELECT * FROM produits");
            $query->execute();
            $produits = $query->fetchAll(PDO::FETCH_ASSOC);

            if ($produits): 
                foreach ($produits as $product): ?>
                    <div class="product-card">
                        <img 
                            src="afficherimage.php?id=<?php echo $product['id_produit']; ?>" 
                            alt="<?php echo htmlspecialchars($product['nom_produit']); ?>"
                            class="product-image"
                        >
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['nom_produit']); ?></h3>
                            <p class="product-description"><?php echo htmlspecialchars($product['description_produit']); ?></p>
                            <div class="product-price"><?php echo number_format($product['prix_produit'], 2); ?> €</div>
                            <form action="../stripe/checkout.php" method="POST">
                                <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($product['id_produit']); ?>">
                                <button type="submit" class="btn">Acheter maintenant</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <p class="no-products">Aucun produit disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .welcome-section {
            text-align: center;
            margin: 3rem 0;
        }

        .welcome-section h1 {
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .subtitle {
            color: var(--text-color);
            font-size: 1.2rem;
            opacity: 0.8;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }

        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-info h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .product-description {
            flex: 1;
            margin-bottom: 1rem;
            color: var(--text-color);
            opacity: 0.8;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .logo {
            font-weight: bold;
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .no-products {
            text-align: center;
            grid-column: 1 / -1;
            padding: 2rem;
            background: var(--white);
            border-radius: 0.5rem;
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>