<?php

$bdd = new PDO('mysql:host=localhost;dbname=cheap', 'root', '');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $bdd->prepare("SELECT image_produit FROM produits WHERE id_produit = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && $row['image_produit']) {
        header("Content-Type: image/jpeg"); // ou png selon ton type
        echo $row['image_produit'];
        exit();
    }
}

http_response_code(404);

?>
