<?php
    
    var_dump($_POST);
    die(;)
    $servername = "localhost";
    $user = "root";
    $password = "";
    $dbname = "moto_form";
    $table = "commande";

    $bdd = new PDO('mysql:host=localhost;dbname=moto_form;', $user, $password);
    $bdd->exec("SET CHARACTER SET utf8");

    // if(isset($_POST['submit'])){
    //     $nom = $_POST['nom'];
    //     $prenom = $_POST['prenom'];
    //     $adresse = $_POST['adresse'];
    //     $paiement = $_POST['paiement'];
    //     $modele = $_POST['modele'];

        // Préparation de la requête d'insertion
        $req = $bdd->prepare("INSERT INTO $table (nom, prenom, adresse, moyen_paiement, modele_moto) VALUES (:nom, :prenom, :adresse, :paiement, :modele)");

        $req->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'paiement' => $paiement,
            'modele' => $modele
        ));

        echo "Merci d'avoir noté !<br>";
?>