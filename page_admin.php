<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
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
        <section class="admin-board">
            <div class="admin-modif">
                <label for="choix-article">Choisir un article :</label>
                <select id="choix-article">
                    <option value="article1">Article 1</option>
                    <option value="article2">Article 2</option>
                    <option value="article3">Article 3</option>
                    <!-- Ajoutez d'autres options si nécessaire -->
                </select>

                <label for="prix-article">Modifier le prix :</label>
                <div class="input-icon">
                    <input type="number" id="prix-article" placeholder="Prix de l'article">
                    <i class="fas fa-euro-sign"></i>
                </div>

                <label for="supprimer-quantite">Supprimer une quantité :</label>
                <div class="input-icon">
                    <input type="number" id="supprimer-quantite" placeholder="Quantité à supprimer">
                    <i class="fas fa-minus"></i>
                </div>

                <label for="ajouter-quantite">Ajouter une quantité :</label>
                <div class="input-icon">
                    <input type="number" id="ajouter-quantite" placeholder="Quantité à ajouter">
                    <i class="fas fa-plus"></i>
                </div>
                <button id="bouton-valider"><i class="fas fa-check"></i> Valider</button>
                <button id="bouton-supprimer"><i class="fas fa-trash-alt"></i> Supprimer l'article</button>

            </div>
        </section>

</body>

</html>