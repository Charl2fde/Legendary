<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/connecter.css">
    <title>Connexion</title>
</head>
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

        // Stocker les informations de l'utilisateur dans des variables de session
        $_SESSION['email'] = $compte['email'];
        $_SESSION['role'] = $compte['role'];

        // Vérifier le rôle de l'utilisateur
        if ($compte['role'] === 'admin') {
            // Rediriger vers une page réservée aux administrateurs
            header("Location: page_admin.php");
            exit;
        } else {
            // Rediriger vers une page réservée aux utilisateurs
            header("Location: page_utilisateur.php");
            exit;
        }
    } else {
        // Les informations de connexion sont invalides
        echo "Identifiants invalides. Veuillez réessayer.";
    }
}
?>


<body>

    <header>
        <nav>
        <a href="index.php"><img class="logo" src="./image/logo.png" alt="logo"></a>
            <ul>
                <li><a href="index.php">Modèles</a></li>
                <li><a href="#">Entretien</a></li>
                <li><a href="#">Notre marque</a></li>
                <li><a href="inscription.php">Connexion</a></li>
            </ul>
        </nav>
    </header>
    <div class="container1">
        <h1>Connexion</h1>
        <form action="connecter.php" method="POST">
            <label for="email">Mail :</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="motdepasse">Mot de passe :</label>
            <input type="password" id="motdepasse" name="motdepasse" required><br><br>

            <input type="submit" value="Se connecter">
            <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscription</a></p>
        </form>

    </div>
</body>

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