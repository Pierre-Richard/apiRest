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

if( !empty($_POST["ville_depart"])){
    $requete = $pdo->prepare("SELECT * FROM vols WHERE ville_depart LIKE :v");
    $requete->bindParam(':v', $_POST["ville_depart"]);
    $requete->execute();
} else {
    $requete = $pdo->prepare("SELECT * FROM vols");
    $requete->execute();
}




$resultats = $requete->fetchAll();

$retour["success"] = true;
$retour["message"] = "Voici les vols";
$retour["results"]["nb"] = count($resultats);
$retour["results"]["vols"] = $resultats;

echo json_encode($retour);