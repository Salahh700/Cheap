<?php
session_start();

// Charger la configuration
define('APP_ACCESS', true);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

// Vérification de l'accès admin
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

if (!isset($_GET['id'])) {
    echo "Aucun compte sélectionné.";
    exit();
}

$id = $_GET['id'];
$compte = $bdd->prepare("SELECT * FROM comptes WHERE id_compte = ?");
$compte->execute([$id]);
$data = $compte->fetch();

if (!$data) {
    echo "Compte introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un compte</title>
</head>
<body>
    <h1>✏️ Modifier le compte n°<?= $data['id_compte'] ?></h1>
    <form action="../controller/controllerupdatecompte.php" method="POST">
        <input type="hidden" name="id_compte" value="<?= $data['id_compte'] ?>">

        <label>Identifiant :</label><br>
        <input type="text" name="identifiant_compte" value="<?= htmlspecialchars($data['identifiant_compte']) ?>" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="text" name="password_compte" value="<?= htmlspecialchars($data['password_compte']) ?>" required><br><br>

        <label>Statut :</label><br>
        <select name="statut_compte" required>
            <option value="disponible" <?= $data['statut_compte'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="indisponible" <?= $data['statut_compte'] == 'indisponible' ? 'selected' : '' ?>>Indisponible</option>
        </select><br><br>

        <button type="submit">💾 Enregistrer</button>
    </form>
</body>
</html>
