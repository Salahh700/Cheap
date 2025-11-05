<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: login.php');
    exit();
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
