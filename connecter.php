<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/connecter.css">
    <title>Connexion</title>
</head>
<body>

<header>
        <nav>
            <img class="logo" src="./image/logo.png" alt="logo">
            <ul>
                <li><a href="index.php">Modèles</a></li>
                <li><a href="commande.php">Achats</a></li>
                <li><a href="#">Entretien</a></li>
                <li><a href="#">Notre marque</a></li>
                <li><a href="inscription.php">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <h1>Connexion</h1>
    <form action="connecter.php" method="POST">
        <label for="email">Mail :</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="motdepasse">Mot de passe :</label>
        <input type="password" id="motdepasse" name="motdepasse" required><br><br>

        <input type="submit" value="Se connecter">
    </form>
    <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscription</a></p>
</body>

<?php
include('connexion.php');
session_start(); // Démarrer une session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Inclure le fichier de connexion à la base de données
    include "connexion.php";

    // Vérifier les informations de connexion
    $query = $db->prepare("SELECT * FROM compte WHERE email = ?");
    $query->execute([$email]);
    $compte = $query->fetch();

    if ($compte && password_verify($motdepasse, $compte['motdepasse'])) {
        // Les informations de connexion sont valides

        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['id'] = $compte['id'];
        $_SESSION['nom'] = $compte['nom'];

        // Rediriger vers une page de succès ou accéder à l'espace membre
        header("Location: espace_membre.php");
        exit;
    } else {
        // Les informations de connexion sont invalides
        echo "Identifiants invalides. Veuillez réessayer.";
    }
}
?>
<footer>
        <div class="container">
          <div class="footer-left">
            <h3>Legendary</h3>
            <p>&copy; 2023 | Tous droits réservés.</p>
          </div>
          <div class="footer-right">
            <ul>
              <li><a href="#">Nous Contacter</a></li>
              <li><a href="#">06 06 03 06 08</a></li>
              <li><a href="#">Instagram</a></li>
            </ul>
          </div>
        </div>
      </footer>
</html>
