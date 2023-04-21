<?php

// Connexion à la base de données
$host = "localhost";
$dbname = "id20605725_legendary";
$username = "id20605725_charles";
$password = "Chatelard0300$"; 
// Connexion à la base de données
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", "id20605725_charles", "Chatelard0300$");
    // Configuration des options de PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

?>