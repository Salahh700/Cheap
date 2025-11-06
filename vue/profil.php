<?php
session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$site_name = "Cheap";

// Vérifier si l'utilisateur est connecté
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

$id_user = $_SESSION['user_id'];

// Récupération des infos utilisateur
$stmt = $bdd->prepare("SELECT username_user, mail_user, date_inscription_user FROM users WHERE id_user = :id");
$stmt->execute(['id' => $id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupération des commandes de l'utilisateur
$sql = "
    SELECT c.id_commande, c.date_commande, p.nom_produit, co.identifiant_compte, co.password_compte
    FROM commandes c
    INNER JOIN produits p ON c.id_produit = p.id_produit
    LEFT JOIN comptes co ON c.id_compte = co.id_compte
    WHERE c.id_user = :id
    ORDER BY c.date_commande DESC
";
$cmds = $bdd->prepare($sql);
$cmds->execute(['id' => $id_user]);
$commandes = $cmds->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_name ?> - Mon profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/modern.css">
    <script src="../style/app.js" defer></script>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><span class="logo">🎵 <?php echo $site_name ?></span></li>
                <li><a href="home.php">Nos abonnements</a></li>
                <li><a href="../controller/controllerlogout.php" class="btn-secondary">Se déconnecter</a></li>
            </ul>
        </nav>

        <div class="profile-container">
            <div class="profile-header">
                <h1>Mon Profil</h1>
                <div class="profile-avatar">👤</div>
            </div>

            <div class="profile-info">
                <div class="info-group">
                    <label>Nom d'utilisateur</label>
                    <p><?= htmlspecialchars($user['username_user']) ?></p>
                </div>
                <div class="info-group">
                    <label>Email</label>
                    <p><?= htmlspecialchars($user['mail_user']) ?></p>
                </div>
                <div class="info-group">
                    <label>Membre depuis</label>
                    <p><?= date('d/m/Y', strtotime($user['date_inscription_user'])) ?></p>
                </div>
            </div>

            <div class="orders-section">
                <h2>Mes commandes</h2>
                <?php if (count($commandes) > 0): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Produit</th>
                                    <th>Date</th>
                                    <th>Identifiant</th>
                                    <th>Mot de passe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commandes as $cmd): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cmd['id_commande']) ?></td>
                                        <td><?= htmlspecialchars($cmd['nom_produit']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($cmd['date_commande'])) ?></td>
                                        <td><?= htmlspecialchars($cmd['identifiant_compte'] ?? 'N/A') ?></td>
                                        <td><span class="badge">🔒 Envoyé par mail</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-orders">
                        <p>Vous n'avez pas encore de commandes</p>
                        <a href="home.php" class="btn">Découvrir nos abonnements</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        .profile-container {
            background: var(--white);
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
            margin: 2rem 0;
            padding: 2rem;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .profile-avatar {
            font-size: 3rem;
            background: var(--light-bg);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .profile-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .info-group {
            background: var(--light-bg);
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .info-group label {
            display: block;
            font-size: 0.875rem;
            color: var(--text-color);
            opacity: 0.7;
            margin-bottom: 0.5rem;
        }

        .info-group p {
            font-weight: 500;
            color: var(--text-color);
        }

        .orders-section {
            margin-top: 2rem;
        }

        .orders-section h2 {
            margin-bottom: 1.5rem;
            color: var(--text-color);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .badge {
            background: var(--light-bg);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .no-orders {
            text-align: center;
            padding: 3rem;
            background: var(--light-bg);
            border-radius: 0.5rem;
        }

        .no-orders p {
            margin-bottom: 1rem;
            color: var(--text-color);
            opacity: 0.7;
        }

        .logo {
            font-weight: bold;
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>
