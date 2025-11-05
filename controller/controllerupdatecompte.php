<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: login.php');
    exit();
}

if (!isset($_POST['id_compte'])) {
    echo "Erreur : ID manquant.";
    exit();
}

$id = $_POST['id_compte'];
$identifiant = $_POST['identifiant_compte'];
$password = $_POST['password_compte'];
$statut = $_POST['statut_compte'];

$update = $bdd->prepare("UPDATE comptes SET identifiant_compte = ?, password_compte = ?, statut_compte = ? WHERE id_compte = ?");
$update->execute([$identifiant, $password, $statut, $id]);

header("Location: ../vue/manageproduits.php");
exit();
