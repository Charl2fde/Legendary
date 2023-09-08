<?php
define('CONNEXION_FILE', 'connexion.php');
include CONNEXION_FILE;

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    // Rediriger vers une page d'erreur ou de connexion
    header("Location: page_erreur.php");
    exit;
}

// Vérifier si le bouton de déconnexion a été cliqué
if (isset($_POST['deconnexion'])) {
    // Supprimer toutes les variables de session
    session_unset();
    // Détruire la session
    session_destroy();
    // Rediriger vers la page de connexion ou une autre page de votre choix
    header("Location: index.php");
    exit;
}

// Vérifier si la connexion à la base de données est établie avec succès
if ($db && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $motoName = $_POST['choix-article'];
    $nouveauPrix = $_POST['prix-article'];
    $quantiteASupprimer = $_POST['supprimer-quantite'];
    $quantiteAAjouter = $_POST['ajouter-quantite'];
    $nouvelleCategorie = $_POST['categorie-article'];

    // Mettre à jour le prix de la moto
    if (!empty($nouveauPrix)) {
        $stmt = $db->prepare("UPDATE moto SET prix = :nouveauPrix WHERE moto_name = :motoName");
        $stmt->execute(array('nouveauPrix' => $nouveauPrix, 'motoName' => $motoName));
    }

    // Mettre à jour la catégorie de la moto
if (!empty($_POST['categorie-article'])) {
    $nouvelleCategorie = $_POST['categorie-article'];
    $stmt = $db->prepare("UPDATE moto_categorie 
                         SET idCategorie = (SELECT idCategorie FROM categorie WHERE nomCategorie = :nouvelleCategorie) 
                         WHERE idMoto = (SELECT idMoto FROM moto WHERE moto_name = :motoName)");
    $stmt->execute(array('nouvelleCategorie' => $nouvelleCategorie, 'motoName' => $motoName));
}


    // Mettre à jour le stock de la moto
    if (isset($_POST['bouton-supprimer'])) {
        $stmt = $db->prepare("UPDATE moto SET stock = 0 WHERE moto_name = :motoName");
        $stmt->execute(array('motoName' => $motoName));
    } else {
        $stmt = $db->prepare("SELECT stock FROM moto WHERE moto_name = :motoName");
        $stmt->execute(array('motoName' => $motoName));
        $stockActuel = $stmt->fetchColumn();
        $nouveauStock = intval($stockActuel) - intval($quantiteASupprimer) + intval($quantiteAAjouter);
        $stmt = $db->prepare("UPDATE moto SET stock = :nouveauStock WHERE moto_name = :motoName");
        $stmt->execute(array('nouveauStock' => $nouveauStock, 'motoName' => $motoName));
    }

    // Rediriger vers la page d'administration après avoir effectué les modifications
    header("Location: page_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Legendary Motorsport</title>
</head>

<body>
<form action="" class="admin" id="formulaire-admin" method="POST"> <!-- Ajout de la méthode POST -->
    <div class="haut-main" id="unique">
        <header>
            <nav>
                <img class="logo" src="./image/logo.png" alt="logo">
                <ul>
                    <li><a href="index.php">Modèles</a></li>
                    <li><a href="#">Entretien</a></li>
                    <li><a href="#">Notre marque</a></li>
                    <li><a href="page_admin.php">Admin</a></li>
                </ul>
            </nav>
        </header>
        <?php
        include "connexion.php";

        // Vérifier si la connexion à la base de données est établie avec succès
        if ($db) {
            // Modifier la requête SQL pour inclure la table "moto_categorie"
            $stmt = $db->prepare("SELECT moto.moto_name, moto.prix, moto.stock, categorie.nomCategorie 
                                 FROM moto 
                                 INNER JOIN moto_categorie ON moto.idMoto = moto_categorie.idMoto 
                                 INNER JOIN categorie ON moto_categorie.idCategorie = categorie.idCategorie");
            $stmt->execute();
            $motoInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Erreur de connexion à la base de données.";
        }
        ?>
        <section class="admin-board">
            <div class="admin-modif">
                <label for="choix-article">Choisir un article :</label>
                <select id="choix-article" onchange="updateMotoInfo()" name="choix-article">
                    <option value="" selected disabled style="display:none">Choisir une moto</option>
                    <?php foreach ($motoInfos as $motoInfo): ?>
                        <option value="<?php echo $motoInfo['moto_name']; ?>"><?php echo $motoInfo['moto_name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="prix-article">Modifier le prix :</label>
                <p class="info">Le prix actuel est de :
                    <span id="prix-actuel"></span>
                </p>
                <div class="input-icon">
                    <input type="number" id="prix-article" placeholder="Prix de l'article" name="prix-article">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <p class="info">Stock actuel :
                    <span id="stock-actuel"></span>
                </p>

                <label for="categorie-article">Modifier la catégorie :</label>
<select id="categorie-article" name="categorie-article">
    <option value="" selected disabled style="display:none">Choisir une catégorie</option>
    <?php
    // Récupérer toutes les catégories existantes depuis la base de données
    $stmt = $db->prepare("SELECT * FROM categorie");
    $stmt->execute();
    $categories = $stmt->fetchAll();

    foreach ($categories as $categorie) {
        echo '<option value="' . $categorie['nomCategorie'] . '">' . $categorie['nomCategorie'] . '</option>';
    }
    ?>
</select>
                

                <label for="ajouter-quantite">Ajouter une quantité :</label>
                <div class="input-icon">
                    <input type="number" id="ajouter-quantite" placeholder="Quantité à ajouter"
                        name="ajouter-quantite">
                    <i class="fas fa-plus"></i>
                </div>

                <label for="supprimer-quantite">Supprimer une quantité :</label>
                <div class="input-icon">
                    <input type="number" id="supprimer-quantite" placeholder="Quantité à supprimer"
                        name="supprimer-quantite">
                    <i class="fas fa-minus"></i>
                </div>
                <button id="bouton-valider" type="submit"><i class="fas fa-check"></i> Valider</button>
                <button id="bouton-supprimer" name="bouton-supprimer" value="supprimer"><i class="fas fa-trash-alt"></i> Mettre le stock à 0</button>
            </div>
        </section>
    </div>
    <form method="POST">
        <button type="submit" name="deconnexion" id="btn-deconnexion">Se déconnecter</button>
    </form>
</form>
<script>
    function updateMotoInfo() {
        var selectedMoto = document.getElementById('choix-article').value;
        var motoInfos = <?php echo json_encode($motoInfos); ?>;

        for (var i = 0; i < motoInfos.length; i++) {
            if (motoInfos[i].moto_name === selectedMoto) {
                document.getElementById('prix-actuel').textContent = motoInfos[i].prix + " €";
                document.getElementById('stock-actuel').textContent = motoInfos[i].stock;
                document.getElementById('categorie-actuelle').textContent = motoInfos[i].nomCategorie;
                break;
            }
        }
    }
</script>
</body>

</html>
