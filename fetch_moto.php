<?php
include "connexion.php";

// Vérifie si le paramètre "moto" est passé via la requête GET
if (isset($_GET['moto'])) {
    $motoName = $_GET['moto'];

    // Requête SQL pour récupérer les informations de la moto
    $stmt = $db->prepare("SELECT * FROM motos WHERE moto_name = :moto");
    $stmt->bindParam(':moto', $motoName);
    $stmt->execute();
    $motoInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retourne les informations de la moto au format JSON
    echo json_encode($motoInfo);
}
?>
