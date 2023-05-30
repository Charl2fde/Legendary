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
                    <li><a href="index.php">Modèles</a></li>
                    <li><a href="commande.php">Achats</a></li>
                    <li><a href="#">Entretien</a></li>
                    <li><a href="#">Notre marque</a></li>
                    <li><a href="inscription.php">Connexion</a></li>
                </ul>
            </nav>
        </header>


        <h2>Ma commande :</h2>

        <div class="formulaire">
            <form action="commande.php" method="post">
                <label id="nom" for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label id="prenom" for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label id="=adresse" for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" required>

                <label id="paiement">Moyen de paiement :</label>
                <input type="text" name="num_carte" placeholder="Numéro de carte bancaire" required>
                <input type="text" name="date_exp" placeholder="Date d'expiration" required>
                <input type="text" name="cvv" placeholder="Code CVV" required>
                <?php
                    error_reporting(0);
                    $moto_name = $_GET['moto_name'];// récupération des données dans l'url
                    $stock = $_GET['stock'];// récupération des données dans l'url
                    $id = $_GET['id_moto'];// récupération des données dans l'url
                    $prix = $_GET['prix'];// récupération des données dans l'url
                    echo"
                        <label>Référence de la moto :</label>
                        <input type='text' name='moto_name' value='$moto_name' required>
                        
                        <label>Quantitée en stock :</label>
                        <input type='text' name='stock' value='$stock' required>

                        <label>Prix de la moto :</label>
                        <input type='text' name='prix' value='$prix' required>"
                ?>
                <input type="submit" value="Commander" name="submit" class="submit">                
            </form>
<?php
    include('connexion.php'); // inclut la connexion a la base
    if(isset($_POST["submit"])) { // si le bouton submit est cliquer
        $moto_name = $_POST['moto_name'];// stocker dans des variables les valeurs des inputs
        $stock = $_POST['stock'];// stocker dans des variables les valeurs des inputs
        $nom = $_POST['nom'];// stocker dans des variables les valeurs des inputs
        $prenom = $_POST['prenom'];// stocker dans des variables les valeurs des inputs
        $adresse = $_POST['adresse'];// stocker dans des variables les valeurs des inputs
        $num_carte = $_POST['num_carte'];// stocker dans des variables les valeurs des inputs
        $date_exp = $_POST['date_exp'];// stocker dans des variables les valeurs des inputs
        $cvv = $_POST['cvv'];// stocker dans des variables les valeurs des inputs
        $stock-=1; // stock a -1

        $query = $db->prepare("UPDATE moto SET stock = '$stock' WHERE moto_name = '$moto_name'");// SQL: Changer la valeur de stock ou le nom de la moto est le même que dans le input
        $query->execute();// éxecution de la requête SQL

        $query2 = $db->prepare("INSERT INTO users (nom, prenom, adresse, num_carte, date_exp, cvv) VALUES (:nom, :prenom, :adresse, :num_carte, :date_exp, :cvv)");// inserer dans la table users dans les colonnes x les valeurs x
        $query2->execute(array(//execuiter la requete non préparée
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':adresse' => $adresse,
            ':num_carte'=>$num_carte,
            'date_exp'=>$date_exp,
            ':cvv'=>$cvv
        ));
    }
?>
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
    

