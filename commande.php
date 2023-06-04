<?php
include "connexion.php";
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion
    header("Location: connecter.php");
    exit;
}

// Récupérer les informations de la moto sélectionnée
if (isset($_GET['id_moto']) && isset($_GET['stock']) && isset($_GET['moto_name']) && isset($_GET['prix'])) {
    $idMoto = $_GET['id_moto'];
    $stock = $_GET['stock'];
    $motoName = $_GET['moto_name'];
    $prix = $_GET['prix'];
} else {
    // Rediriger vers la page utilisateur si les informations de la moto sont manquantes
    header("Location: page_utilisateur.php");
    exit;
}

// Initialiser les variables pour éviter les erreurs
$nom = $prenom = $adresse = $codePostal = $email = $numCarte = $dateExp = $cvv = "";
$message = "";

// Traitement du formulaire de commande
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $codePostal = $_POST['code_postal'];
    $email = $_POST['email'];
    $numCarte = $_POST['num_carte'];
    $dateExp = $_POST['date_exp'];
    $cvv = $_POST['cvv'];

    // Vérifier si la moto est en stock
    if ($stock > 0) {
        // Réduire le stock de la moto
        $stock--;

        // Mettre à jour le stock dans la table "moto"
        $query = $db->prepare("UPDATE moto SET stock = ? WHERE idMoto = ?");
        $query->execute([$stock, $idMoto]);

        // Insérer la commande dans la table "commande"
        $query = $db->prepare("INSERT INTO commande (nom, prenom, id_moto, prix, adresse, email, code_postal, dateCommande) VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())");
        $query->execute([$nom, $prenom, $idMoto, $prix, $adresse, $email, $codePostal]);

        // Récupérer l'ID de la dernière commande insérée
        $idCommande = $db->lastInsertId();

        // Insérer la relation dans la table "contenir"
        $query = $db->prepare("INSERT INTO contenir (idCommande, idMoto) VALUES (?, ?)");
        $query->execute([$idCommande, $idMoto]);


        // Récupérer l'ID du compte de l'utilisateur connecté
        $query = $db->prepare("SELECT idCompte FROM compte WHERE email = ?");
        $query->execute([$email]);
        $compte = $query->fetch();

        if ($compte) {
            $idCompte = $compte['idCompte'];

            // Insérer les données dans la table "passer"
            $query = $db->prepare("INSERT INTO passer (idCommande, idCompte) VALUES (?, ?)");
            $query->execute([$idCommande, $idCompte]);
        } else {
            // Gérer le cas où l'ID du compte n'a pas été trouvé
            echo "Erreur : ID du compte non trouvé.";
        }

        // Message de succès
        $message = "La commande a été passée avec succès.";
    }
}

// Récupérer l'email du compte connecté
$email = $_SESSION['email'] ?? '';
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
                <li><a href="#">Entretien</a></li>
                <li><a href="#">Notre marque</a></li>
                <li><a href="profil.php">Mon profil</a></li>
            </ul>
        </nav>
    </header>

    <h2>Ma commande :</h2>

    <div class="formulaire">
        <form action="commande.php?id_moto=<?php echo $idMoto; ?>&stock=<?php echo $stock; ?>&moto_name=<?php echo urlencode($motoName); ?>&prix=<?php echo $prix; ?>" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo $adresse; ?>" required>

            <label for="code_postal">Code Postal :</label>
            <input type="text" id="code_postal" name="code_postal" value="<?php echo htmlspecialchars($codePostal ?? ''); ?>" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>

            <label for="moyen_paiement">Moyen de paiement :</label>
            <input type="text" id="num_carte" name="num_carte" placeholder="Numéro de carte bancaire" required>
            <input type="text" id="date_exp" name="date_exp" placeholder="Date d'expiration" required>
            <input type="text" id="cvv" name="cvv" placeholder="Code CVV" required>

            <input type="hidden" name="id_moto" value="<?php echo $idMoto; ?>">
            <input type="hidden" name="stock" value="<?php echo $stock; ?>">
            <input type="hidden" name="moto_name" value="<?php echo $motoName; ?>">
            <input type="hidden" name="prix" value="<?php echo $prix; ?>">

            <input type="submit" value="Commander" name="submit" class="submit">
        </form>
        <?php echo $message; ?>
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