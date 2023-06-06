<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inscription.css">
    <title>Inscription</title>
</head>

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
    <h1>Inscription</h1>
    
        <form action="inscription.php" method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required><br><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom"><br><br>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse"><br><br>

            <label for="code_postal">Code Postal :</label>
            <input type="text" id="code_postal" name="code_postal"><br><br>

            <label for="email">Mail :</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="motdepasse">Mot de passe :</label>
            <input type="password" id="motdepasse" name="motdepasse" required><br><br>

            <input class='boutton' type="submit" value="S'inscrire">

            <p>Déjà un compte ? <a href="connecter.php">Connexion</a></p>
        </form>
    </div>
</body>

<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $code_postal = $_POST['code_postal'];
    $email = $_POST['email'];
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT); // Hasher le mot de passe

    // Inclure le fichier de connexion à la base de données
    include "connexion.php";

    // Préparer et exécuter la requête d'insertion
    $query = $db->prepare("INSERT INTO compte (nom, prenom, adresse, code_postal, email, motdepasse, role) VALUES (?, ?, ?, ?, ?, ?, 'utilisateur')");
    $query->execute([$nom, $prenom, $adresse, $code_postal, $email, $motdepasse]);

    // Rediriger vers une page de succès ou afficher un message
    header("Location: connecter.php");
    exit;
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
