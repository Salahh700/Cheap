<?php
session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$site_name = "Cheap";
$current_year = date('Y');

// Vérifier que c'est bien l'admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['type_user']) || $_SESSION['type_user'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
try {
    $bdd = pdo();
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer tous les utilisateurs (les admins peuvent voir tous les users)
$query = $bdd->query("SELECT * FROM users ORDER BY id_user");
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
    <style>
        body { font-family: Arial; padding: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: #FF5A5F; font-weight: bold; }
        a:hover { text-decoration: underline; }
        .back { margin-bottom: 1rem; display: inline-block; }
    </style>
</head>
<body>

    <a class="back" href="paneladmin.php">← Retour au panneau admin</a>
    <h1>👤 Liste des utilisateurs</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id_user']) ?></td>
                    <td><?= htmlspecialchars($user['mail_user']) ?></td>
                    <td><?= htmlspecialchars($user['date_inscription_user']) ?></td>
                    <td>
                        <a href="../controller/controllerdeleteuser.php?id_user=<?= $user['id_user'] ?>" onclick="return confirm('Confirmer la suppression de cet utilisateur ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
