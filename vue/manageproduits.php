<?php
session_start();
$site_name = "Cheap";
$current_year = date('Y');
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

// Vérification de la session admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name ?> - Gestion des produits</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/modern.css">
    <script src="../style/app.js" defer></script>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><span class="logo">🎵 <?php echo $site_name ?> Admin</span></li>
                <li><a href="paneladmin.php">Tableau de bord</a></li>
                <li><a href="../controller/controllerlogout.php" class="btn-secondary">Se déconnecter</a></li>
            </ul>
        </nav>

        <div class="admin-container">
            <!-- Section Produits -->
            <section class="admin-section">
                <div class="section-header">
                    <h2>Gestion des produits</h2>
                    <button class="btn" onclick="showModal('addProductModal')">+ Ajouter un produit</button>
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
                                    <p><?php echo htmlspecialchars($product['description_produit']); ?></p>
                                    <div class="product-details">
                                        <span class="price"><?php echo number_format($product['prix_produit'], 2); ?> €</span>
                                        <span class="stock">Stock: <?php echo $product['stock_produit']; ?></span>
                                    </div>
                                    <div class="product-actions">
                                        <a href="../controller/controllerdeleteproduit.php?id_produit=<?php echo $product['id_produit']; ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                            Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    else: ?>
                        <p class="no-data">Aucun produit trouvé.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Section Comptes -->
            <section class="admin-section">
                <div class="section-header">
                    <h2>Gestion des comptes</h2>
                    <button class="btn" onclick="showModal('addAccountModal')">+ Ajouter un compte</button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Plateforme</th>
                                <th>Identifiant</th>
                                <th>Mot de passe</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $bdd->prepare("
                                SELECT c.*, p.nom_produit 
                                FROM comptes c 
                                JOIN produits p ON c.id_produit = p.id_produit
                            ");
                            $query->execute();
                            $comptes = $query->fetchAll(PDO::FETCH_ASSOC);

                            if ($comptes): 
                                foreach ($comptes as $compte): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($compte['id_compte']); ?></td>
                                        <td><?php echo htmlspecialchars($compte['nom_produit']); ?></td>
                                        <td><?php echo htmlspecialchars($compte['identifiant_compte']); ?></td>
                                        <td>
                                            <span class="password-mask">••••••••</span>
                                            <span class="password-real" style="display: none;">
                                                <?php echo htmlspecialchars($compte['password_compte']); ?>
                                            </span>
                                            <button class="btn-icon" onclick="togglePassword(this)">👁️</button>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo $compte['statut_compte']; ?>">
                                                <?php echo $compte['statut_compte']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="editcompte.php?id=<?php echo $compte['id_compte']; ?>" 
                                                   class="btn btn-small">
                                                    ✏️
                                                </a>
                                                <a href="../controller/controllerdeletecompte.php?id_compte=<?php echo $compte['id_compte']; ?>" 
                                                   class="btn btn-small btn-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce compte ?')">
                                                    🗑️
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="6" class="no-data">Aucun compte trouvé.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal Ajout Produit -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Ajouter un produit</h2>
                <span class="close" onclick="hideModal('addProductModal')">&times;</span>
            </div>
            <form action="../controller/controlleraddproduit.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom_produit">Nom du produit</label>
                    <input type="text" id="nom_produit" name="nom_produit" required>
                </div>

                <div class="form-group">
                    <label for="description_produit">Description</label>
                    <textarea id="description_produit" name="description_produit" required></textarea>
                </div>

                <div class="form-group">
                    <label for="prix_produit">Prix (€)</label>
                    <input type="number" id="prix_produit" name="prix_produit" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="image_produit">Image du produit</label>
                    <input type="file" id="image_produit" name="image_produit" accept="image/*" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideModal('addProductModal')">Annuler</button>
                    <button type="submit" class="btn">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ajout Compte -->
    <div id="addAccountModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Ajouter un compte</h2>
                <span class="close" onclick="hideModal('addAccountModal')">&times;</span>
            </div>
            <form action="../controller/controlleraddcompte.php" method="POST">
                <div class="form-group">
                    <label for="produit">Plateforme</label>
                    <select name="produit" id="produit" required>
                        <option value="">-- Choisir une plateforme --</option>
                        <?php
                        $requete = "SELECT id_produit, nom_produit FROM produits";
                        $resultat = $bdd->query($requete);
                        while ($row = $resultat->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['id_produit']; ?>">
                                <?php echo htmlspecialchars($row['nom_produit']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_compte">Identifiant</label>
                    <input type="text" id="id_compte" name="id_compte" required>
                </div>

                <div class="form-group">
                    <label for="mdp_compte">Mot de passe</label>
                    <input type="password" id="mdp_compte" name="mdp_compte" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideModal('addAccountModal')">Annuler</button>
                    <button type="submit" class="btn">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .admin-container {
            margin: 2rem 0;
        }

        .admin-section {
            background: var(--white);
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            padding: 1.5rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.disponible {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-badge.indisponible {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-small {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            opacity: 0.7;
            transition: var(--transition);
        }

        .btn-icon:hover {
            opacity: 1;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background-color: var(--white);
            margin: 5% auto;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .close {
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.7;
            transition: var(--transition);
        }

        .close:hover {
            opacity: 1;
        }

        .modal-footer {
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn-danger {
            background-color: #dc2626;
        }

        .btn-danger:hover {
            background-color: #991b1b;
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: var(--text-color);
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .section-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <script>
        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function hideModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function togglePassword(button) {
            const row = button.closest('td');
            const mask = row.querySelector('.password-mask');
            const real = row.querySelector('.password-real');
            
            if (mask.style.display === 'none') {
                mask.style.display = 'inline';
                real.style.display = 'none';
                button.innerHTML = '👁️';
            } else {
                mask.style.display = 'none';
                real.style.display = 'inline';
                button.innerHTML = '🔒';
            }
        }

        // Fermer les modales si on clique en dehors
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>