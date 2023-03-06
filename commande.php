

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="commande.css">
    <link rel="shortcut icon" href="./image/Motorcycle-Helmet-PNG-Background.ico" type="image/x-icon">
    <title>Legendary Motorsport</title>
</head>

<body>
        <header>
            <nav>
                <img class="logo" src="./image/logo-removebg-preview.png" alt="logo">
                <ul>
                    <li><a href="index.html">Modèles</a></li>
                    <li><a href="commande.html">Achats</a></li>
                    <li><a href="#">Entretien</a></li>
                    <li><a href="#">Notre marque</a></li>
                    <li><a href="#">Contact</a></li>
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

                <label id="paiement" for="paiement">Moyen de paiement :</label>
                <select id="paiement" name="paiement" required>
                    <option value="carte">Carte de crédit</option>
                    <option value="paypal">PayPal</option>
                    <option value="virement">Virement bancaire</option>
                </select>

                <label id="modele" for="modele">Modèle de moto souhaité :</label>
                <select id="modele" name="modele" required>
                    <option value="Honda CB1000R">Honda CB1000R</option>
                    <option value="Kawasaki Z900">Kawasaki Z900</option>
                    <option value="Yamaha MT-09">Yamaha MT-09</option>
                    <option value="Suzuki GSX-S1000">Suzuki GSX-S1000</option>
                    <option value="BMW S1000R">BMW S1000R</option>
                    <option value="Ducati Monster 821">Ducati Monster 821</option>
                </select>

                <input type="submit" value="Commander">
                
            </form>
            <?php
    include('connexion.php');
    $table = 'moto_form';
    $nom = '';
    $prenom = '';
    $adresse = '';
    $paiement = '';
    $modele = '';
                    
    if(isset($_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['paiement'], $_POST['modele'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $adresse = $_POST['adresse'];
        $paiement = $_POST['paiement'];
        $modele = $_POST['modele'];

        var_dump($nom, $prenom, $adresse, $paiement, $modele);
    }

    $req = $db->prepare("INSERT INTO $table (nom, prenom, adresse, paiement, moto) VALUES (:nom, :prenom, :adresse, :paiement, :modele)");

    $req->execute(array(
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':adresse' => $adresse,
        ':paiement' => $paiement,
        ':modele' => $modele,
    ));

    var_dump($req);

    echo "Merci d'avoir noté !<br>";

    var_dump($_POST);
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
    

