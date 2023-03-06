<?php

// Paramètres de connexion
$host = 'localhost';
$dbname = 'moto_form';
$username = 'root';
$password = '';

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configuration des options de PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

?>