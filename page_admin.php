<?php
include "connexion.php";

// Vérifier si la connexion à la base de données est établie avec succès
if ($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $motoName = $_POST['choix-article'];
        $nouveauPrix = $_POST['prix-article'];
        $quantiteASupprimer = $_POST['supprimer-quantite'];
        $quantiteAAjouter = $_POST['ajouter-quantite'];

        // Mettre à jour le prix de la moto
        if (!empty($nouveauPrix)) {
            $stmt = $db->prepare("UPDATE moto SET prix = :nouveauPrix WHERE moto_name = :motoName");
            $stmt->execute(array('nouveauPrix' => $nouveauPrix, 'motoName' => $motoName));
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
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <form action="" class="admin" id="formulaire-admin" method="POST"> <!-- Ajout de la méthode POST -->
        <div class="haut-main" id="unique">
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
            <?php
            include "connexion.php";

            // Vérifier si la connexion à la base de données est établie avec succès
            if ($db) {
                $stmt = $db->query("SELECT moto_name, prix, stock FROM moto");
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
                            <option value="<?php echo $motoInfo['moto_name']; ?>"><?php echo $motoInfo['moto_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="prix-article">Modifier le prix :</label>
                    <p class="info">Le prix actuel est de :
                        <span id="prix-actuel"></span>
                    </p>
                    <div class="input-icon">
                        <input type="number" id="prix-article" placeholder="Prix de l'article" name="prix-article">
                        <!-- Ajout de l'attribut name -->
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <p class="info">Stock actuel :
                        <span id="stock-actuel"></span>
                    </p>

                    <label for="ajouter-quantite">Ajouter une quantité :</label>
                    <div class="input-icon">
                        <input type="number" id="ajouter-quantite" placeholder="Quantité à ajouter"
                            name="ajouter-quantite"> <!-- Ajout de l'attribut name -->
                        <i class="fas fa-plus"></i>
                    </div>

                    <label for="supprimer-quantite">Supprimer une quantité :</label>
                    <div class="input-icon">
                        <input type="number" id="supprimer-quantite" placeholder="Quantité à supprimer"
                            name="supprimer-quantite"> <!-- Ajout de l'attribut name -->
                        <i class="fas fa-minus"></i>
                    </div>
                    <button id="bouton-valider" type="submit"><i class="fas fa-check"></i> Valider</button>
                    <!-- Ajout du type submit -->
                    <button id="bouton-supprimer" name="bouton-supprimer" value="supprimer"><i class="fas fa-trash-alt"></i> Mettre le stock a 0</button>
                </div>
            </section>
        </div>
    </form>
    <script>
        function updateMotoInfo() {
            var selectedMoto = document.getElementById('choix-article').value;
            var motoInfos = <?php echo json_encode($motoInfos); ?>;

            for (var i = 0; i < motoInfos.length; i++) {
                if (motoInfos[i].moto_name === selectedMoto) {
                    document.getElementById('prix-actuel').textContent = motoInfos[i].prix + " €";
                    document.getElementById('stock-actuel').textContent = motoInfos[i].stock;
                    break;
                }
            }
        }

    </script>
    
</body>

</html>
