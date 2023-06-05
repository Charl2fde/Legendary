<?php
// Inclure le fichier de configuration
include "./config/config.php";
// Connexion à la base de données
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configuration des options de PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Test de la connexion à la base de données
function testDatabaseConnection()
{
    global $db;
    // Vérifier si la connexion est établie avec succès
    if ($db !== null) {
        echo "La connexion à la base de données a réussi.";
    } else {
        echo "La connexion à la base de données a échoué.";
    }
}

// Exécuter le test
testDatabaseConnection();
?>
