<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/profil.css">
    <link rel="shortcut icon" href="./image/Motorcycle-Helmet-PNG-Background.ico" type="image/x-icon">
    <title>Legendary Motorsport</title>
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
                <li><a href="profil.php">Mon profil</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="infos-perso">
            <?php
            include('connexion.php');
            session_start();

            // Inclure le fichier de connexion à la base de données
            include "connexion.php";

            // Vérifier si l'utilisateur est connecté
            if (isset($_SESSION['email'])) {
                // Récupérer les informations personnelles de l'utilisateur à partir de la base de données
                $email = $_SESSION['email'];

                // Utiliser la variable $email pour effectuer une requête SQL et récupérer les informations personnelles
                $query = $db->prepare("SELECT * FROM compte WHERE email = ?");
                $query->execute([$email]);
                $utilisateur = $query->fetch();
            ?>
                <h2>Informations personnelles</h2>
                <p><strong>Nom :</strong> <?php echo $utilisateur['nom']; ?></p>
                <p><strong>Email :</strong> <?php echo $utilisateur['email']; ?></p>
                <!-- Afficher d'autres informations personnelles selon la structure de votre table utilisateurs -->
            <?php
            } else {
                // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
                header("Location: connexion.php");
                exit;
            }
            ?>
        </section>

        <section class="historique">
            <h2>Historique d'achat</h2>
            <?php
            // Récupérer l'historique d'achat de l'utilisateur à partir de la base de données
            // Effectuer la requête SQL appropriée et afficher les résultats ici
            ?>
        </section>
    </main>
</body>

</html>