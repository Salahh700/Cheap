<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id_user'])) {
    $id = intval($_GET['id_user']);

    if ($id !== 1) {
        $delete = $bdd->prepare("DELETE FROM users WHERE id_user = :id");
        $delete->execute(['id' => $id]);
    }
}

header('Location: ../vue/manageusers.php');
exit();
?>