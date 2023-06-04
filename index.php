<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./image/Motorcycle-Helmet-PNG-Background.ico" type="image/x-icon">
    <title>Legendary Motorsport</title>
</head>

<body>
    <div class="haut-main">
        <header>
            <nav>
                <img class="logo" src="./image/logo.png" alt="logo">
                <ul>
                    <li><a href="index.php">Modèles</a></li>
                    <li><a href="#">Entretien</a></li>
                    <li><a href="#">Notre marque</a></li>
                    <li><a href="inscription.php">Connexion</a></li>
                </ul>
            </nav>
        </header>
        <section class="titre">
            <h1>Nouveaux modèles pour <br><span>2023</span></h1>
        </section>
    </div>
    <?php
    include "connexion.php";
    $query = $db->prepare("SELECT * FROM moto");
    $query->execute();
    $data = $query->fetchAll();
    echo '
    <main>
        <h2>Modèles</h2>
        <hr>
        <section class="moto">';
    foreach ($data as $row) {
        $id_moto = $row['idMoto'];
        $stock = $row['stock'];
        $moto_name = $row['moto_name'];
        $prix = $row['prix'];
        echo "<div class='véhicule'>
                <div class='Honda'>
                    <a href='connecter.php'>
                        <img src='./moto/$row[image_url]' alt='$row[moto_name]'>
                    </a>
                    <h3>$row[moto_name]</h3>
                    <p>Prix: $row[prix]</p>
                    <p>En stock : $row[stock]</p>
                </div>
            </div>";
    }
    echo '
        </section>
    </main>';
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
</body>

</html>
