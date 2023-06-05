<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion
    header("Location: connecter.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
include('connexion.php');
?>

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
            <a href="index.php"><img class="logo" src="./image/logo.png" alt="logo"></a>
            <ul>
                <li><a href="page_utilisateur.php">Modèles</a></li>
                <li><a href="#">Entretien</a></li>
                <li><a href="#">Notre marque</a></li>
                <li><a href="profil.php">Mon profil</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="infos-perso">
            <h2>Informations personnelles</h2>
            <?php
            // Récupérer l'email de l'utilisateur connecté depuis la session
            $email = $_SESSION['email'];

            // Requête pour récupérer les informations personnelles de l'utilisateur
            $query = $db->prepare("SELECT * FROM compte WHERE email = ?");
            $query->execute([$email]);
            $compte = $query->fetch();
            ?>
            <p><strong>Prénom :</strong> <?php echo isset($compte['prenom']) ? $compte['prenom'] : ''; ?></p>
            <p><strong>Nom :</strong> <?php echo isset($compte['nom']) ? $compte['nom'] : ''; ?></p>
            <p><strong>Email :</strong> <?php echo $email; ?></p>
            <p><strong>Adresse :</strong> <?php echo isset($compte['adresse']) ? $compte['adresse'] : ''; ?></p>
            <p><strong>Code Postal :</strong> <?php echo isset($compte['code_postal']) ? $compte['code_postal'] : ''; ?></p>
            <p><strong>Mot de passe :</strong> *********</p>
            <!-- Ajouter ici d'autres informations personnelles selon votre structure de base de données -->
        </section>

        <section class="historique">
            <h2>Historique d'achat</h2>
            <table>
                <caption>Description de la commande</caption>
                <tr>
                    <th>Modèle de la moto</th>
                    <th>ID de commande</th>
                    <th>Date de commande</th>
                    <th>Prix payé</th>
                </tr>
                <?php
                // Requête pour récupérer l'historique d'achat de l'utilisateur
                $query = $db->prepare("SELECT moto.moto_name, commande.idCommande, commande.dateCommande, commande.prix FROM commande LEFT JOIN moto ON commande.id_moto = moto.idMoto WHERE commande.email = ?");
                $query->execute([$email]);
                $commandes = $query->fetchAll();

                // Afficher chaque commande dans le tableau
                foreach ($commandes as $commande) {
                    echo "<tr>";
                    echo "<td>" . $commande['moto_name'] . "</td>";
                    echo "<td>" . $commande['idCommande'] . "</td>";
                    echo "<td>" . $commande['dateCommande'] . "</td>";
                    echo "<td>" . $commande['prix'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>

        <a href="deconnecter.php" class="deconnexion-button">Déconnexion</a>
    </main>

</body>

</html>
