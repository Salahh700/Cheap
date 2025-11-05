<?php
session_start();
$site_name = "Cheap";
$current_year = date('Y');

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

// Vérification de l'accès admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: login.php');
    exit();
}

// Récupération des commandes
$sql = "
    SELECT 
        commandes.id_commande,
        commandes.date_commande,
        commandes.id_compte,
        users.username_user,
        users.mail_user,
        produits.nom_produit
    FROM commandes
    INNER JOIN users ON commandes.id_user = users.id_user
    INNER JOIN produits ON commandes.id_produit = produits.id_produit
    ORDER BY commandes.date_commande DESC
";

$commandes = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commandes - <?= $site_name ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f5f5f5;
        }
        h1 {
            color: #FF5A5F;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #FF5A5F;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a.back {
            display: inline-block;
            margin-bottom: 15px;
            color: #FF5A5F;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <a href="paneladmin.php" class="back">⬅ Retour au panneau admin</a>
    <h1>🧾 Liste des commandes</h1>

    <?php if (count($commandes) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Numéro de commande</th>
                    <th>ID du compte</th>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Produit</th>
                    <th>Date de commande</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $cmd): ?>
                    <tr>
                        <td><?= htmlspecialchars($cmd['id_commande']) ?></td>
                        <td><?= htmlspecialchars($cmd['id_compte']) ?></td>
                        <td><?= htmlspecialchars($cmd['username_user']) ?></td>
                        <td><?= htmlspecialchars($cmd['mail_user']) ?></td>
                        <td><?= htmlspecialchars($cmd['nom_produit']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($cmd['date_commande'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune commande trouvée.</p>
    <?php endif; ?>

</body>
</html>
