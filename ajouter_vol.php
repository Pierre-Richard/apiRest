<?php 
/* le navigateur va lire mon fichier index.php et va l'afficher en json */
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=localhost;port=8889;dbname=api', 'root', 'root');
    $retour["success"] = true;
    $retour["message"] = "Connexion à la base de donnée avec réussie";
} catch(Exception $e){
    $retour["success"] = false;
    $retour["message"] = "Connexion à la base de donnée impossible";
}

if( !empty($_POST["ville_depart"]) && !empty($_POST["ville_destination"]) && !empty($_POST["date_depart"]) &&!empty($_POST["nb_heure_vol"]) && !empty($_POST["prix"])){

    if( intval($_POST["prix"]) > 0){
        $requete = $pdo->prepare("INSERT INTO `vols` (`id`, `ville_depart`, `ville_destination`, `date_depart`, `nb_heure_vol`, `prix`) VALUES (NULL, ':ville1', ':ville2', ':date_vol', ':nb', ':prix');");
        $requete->bindParam(':ville1', $_POST["ville_depart"]);
        $requete->bindParam(':ville2', $_POST["ville_destination"]);
        $requete->bindParam(':date_vol', $_POST["date_depart"]);
        $requete->bindParam(':nb', $_POST["nb_heure_vol"]);
        $requete->bindParam(':prix', $_POST["prix"]);
        $requete->execute(); 

        $retour["success"] = true;
        $retour["message"] = "Le vol a été ajouté";
        $retout["results"] = array();


    }else {
        $retour["success"] = false;
        $retour["message"] = "Le prix n'est pas correct";
    }

} else {
    
    $retour["success"] = false;
    $retour["message"] = "Il manque des infos";
}





echo json_encode($retour);