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
                <li><a href="page_utilisateur.php">Modèles</a></li>
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

            // Vérifier si l'utilisateur est connecté
            if (isset($_SESSION['email'])) {
                // Récupérer les informations personnelles de l'utilisateur à partir de la base de données
                $email = $_SESSION['email'];

                $query = $db->prepare("SELECT * FROM compte WHERE email = ?");
                $query->execute([$email]);
                $compte = $query->fetch();
            ?>
                <h2>Informations personnelles</h2>
                <p><strong>Prénom :</strong> <?php echo isset($compte['prenom']) ? $compte['prenom'] : ''; ?></p>
                <p><strong>Nom :</strong> <?php echo isset($compte['nom']) ? $compte['nom'] : ''; ?></p>
                <p><strong>Email :</strong> <?php echo $email; ?></p>
                <p><strong>Adresse :</strong> <?php echo isset($compte['adresse']) ? $compte['adresse'] : ''; ?></p>
                <p><strong>Code Postal :</strong> <?php echo isset($compte['code_postal']) ? $compte['code_postal'] : ''; ?></p>
                <p><strong>Mot de passe :</strong> *********</p>
                <!-- Afficher d'autres informations personnelles selon votre structure de table -->
            <?php
            } else {
                // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
                header("Location: connecter.php");
                exit;
            }
            ?>

        </section>

        <section class="historique">
            <h2>Historique d'achat</h2>
            <table>
                <tr>
                    <th>Modèle de la moto</th>
                    <th>ID de commande</th>
                    <th>Date de commande</th>
                    <th>Prix payé</th>
                </tr>
                <?php
                // Récupérer l'historique d'achat de l'utilisateur à partir de la base de données
                $query = $db->prepare("SELECT moto.moto_name, commande.id, commande.date, commande.prix FROM commande LEFT JOIN moto ON commande.id_moto = moto.id WHERE commande.id = (SELECT id FROM compte WHERE email = ?)");
                $query->execute([$email]);
                $commandes = $query->fetchAll();

                // Afficher chaque commande dans le tableau
                foreach ($commandes as $commande) {
                    echo "<tr>";
                    echo "<td>" . $commande['moto_name'] . "</td>";
                    echo "<td>" . $commande['id'] . "</td>";
                    echo "<td>" . $commande['date'] . "</td>";
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
