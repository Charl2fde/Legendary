<?php
include('connexion.php');
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id_compte'])) {
    // Récupérer l'ID du compte connecté
    $id_compte = $_SESSION['id_compte'];
    // Rediriger vers la page de connexion
    header("Location: connecter.php");
    exit;
}


error_reporting(0);

if (isset($_POST["submit"])) {
    // Récupérer les valeurs des champs du formulaire
    $id_moto = $_POST['id_moto'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $code_postal = $_POST['code_postal'];
    $email = $_POST['email'];

    // Effectuer les opérations nécessaires (par exemple, récupérer le prix de la moto)
    $query_moto = $db->prepare("SELECT prix FROM moto WHERE id = :id_moto");
    $query_moto->execute(array(':id_moto' => $id_moto));
    $row = $query_moto->fetch(PDO::FETCH_ASSOC);
    $prix = $row['prix'];

    // Récupérer l'ID du compte connecté
    $id_compte = $_SESSION['id_compte'];

    // Insérer les données dans la table commande
    $query = $db->prepare("INSERT INTO commande (id_moto, prix, prenom, nom, adresse, code_postal, email, id_compte)
    VALUES (:id_moto, :prix, :prenom, :nom, :adresse, :code_postal, :email, :id_compte)");
    $query->execute(array(
        ':id_moto' => $id_moto,
        ':prix' => $prix,
        ':prenom' => $prenom,
        ':nom' => $nom,
        ':adresse' => $adresse,
        ':code_postal' => $code_postal,
        ':email' => $email,
        ':id_compte' => $id_compte,
    ));

    // Mettre à jour le stock de la moto
    $query = $db->prepare("UPDATE moto SET stock = stock - 1 WHERE id = :id_moto");
    $query->execute(array(':id_moto' => $id_moto));

    // Rediriger vers une page de confirmation ou une autre page appropriée
    header("Location: page_utilisateur.php");
    exit();
}

// Récupérer les informations du compte connecté
$id_compte = $_SESSION['id_compte'];
$query_compte = $db->prepare("SELECT prenom, nom, adresse, code_postal, email FROM compte WHERE id = :id_compte");
$query_compte->execute(array(':id_compte' => $id_compte));
$compte = $query_compte->fetch(PDO::FETCH_ASSOC);
$prenom = $compte['prenom'];
$nom = $compte['nom'];
$adresse = $compte['adresse'];
$code_postal = $compte['code_postal'];
$email = $compte['email'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/commande.css">
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

    <h2>Ma commande :</h2>

    <div class="formulaire">
        <form action="commande.php" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo $adresse; ?>" required>

            <label for="code_postal">Code Postal :</label>
            <input type="text" id="code_postal" name="code_postal" value="<?php echo $code_postal; ?>" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

            <label for="moyen_paiement">Moyen de paiement :</label>
            <input type="text" id="num_carte" name="num_carte" placeholder="Numéro de carte bancaire" required>
            <input type="text" id="date_exp" name="date_exp" placeholder="Date d'expiration" required>
            <input type="text" id="cvv" name="cvv" placeholder="Code CVV" required>

            <?php
            $moto_name = $_GET['moto_name'];
            $id = $_GET['id_moto'];
            echo "
                <input type='hidden' name='id_moto' value='$id'>
                <label for='moto_name'>Nom de la moto :</label>
                <input type='text' id='moto_name' name='moto_name' value='$moto_name' readonly>
            ";
            ?>

            <input type="submit" value="Commander" name="submit" class="submit">
        </form>
    </div>

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
</body>

</html>
